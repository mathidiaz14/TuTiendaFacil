<?php

namespace App\Http\Controllers\Plugins\Blog;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Plugins\Blog\BlogComentario;
use Auth;

class BlogControladorComentario extends Controller
{

    private $path = "plugins.blog.comentario.";

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $comentarios = Auth::user()->empresa->blogComentarios;

        return view($this->path."index", compact('comentarios'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $old = BlogComentario::find($request->id);

        if(($old == null) or (!control_empresa($old->empresa_id)))
        {
            error('Error al responder comentario');
            return back();
        }

        $comentario             = new BlogComentario();
        $comentario->empresa_id = $old->empresa_id;
        $comentario->entrada_id = $old->entrada_id;
        $comentario->user_id    = usuario();
        $comentario->user_name  = usuario('nombre');
        $comentario->user_email = usuario('email');
        $comentario->contenido  = $request->respuesta;
        $comentario->estado     = "aprobado";
        $comentario->parent_id  = $old->id;
        $comentario->save();

        registro(
            "info",
            usuario(),
            usuario('empresa'),
            "Blog",
            "Respuesta comentario",
            "Se responde comentario"
        );

        exito("El comentario se respondio correctamente");
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $comentario = BlogComentario::find($id);

        if(($comentario == null) or (!control_empresa($comentario->empresa_id)))
        {
            error('Erro al aprobar categoria');
            return back();
        }

        if($comentario->estado == "pendiente")
        {
            $comentario->estado = "aprobado";
            $comentario->save();

        }
        
        registro(
            "info",
            usuario(),
            usuario('empresa'),
            "Blog",
            "Aprobar comentario",
            "Se aprueba comentario"
        );

        exito("El comentario se aprobo correctamente");
        return back();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $comentario = BlogComentario::find($id);

        if(($comentario == null) or (!control_empresa($comentario->empresa_id)))
        {
            error('Erro al eliminar el comentario');
            return back();
        }
        
        $this->borrar_hijo($comentario);
        
        registro(
            "info",
            usuario(),
            usuario('empresa'),
            "Blog",
            "Eliminar comentario",
            "Se elimina comentario"
        );

        exito('El comentario se borro correctamente');
        return back();
    }

    private function borrar_hijo($comentario)
    {
        foreach($comentario->hijos as $hijo)
            $this->borrar_hijo($hijo);

        $comentario->delete();
    }
}
