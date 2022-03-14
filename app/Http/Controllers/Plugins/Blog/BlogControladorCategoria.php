<?php

namespace App\Http\Controllers\Plugins\Blog;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Plugins\Blog\BlogCategoria;
use Auth;

class BlogControladorCategoria extends Controller
{

    private $path = "plugins.blog.categoria.";

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categorias = Auth::user()->empresa->blogCategorias;

        return view($this->path."index", compact('categorias'));
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
        $url = str_replace(" ", "_", strtolower($request->titulo));
        $old = Auth::user()->empresa->blogCategorias->where('url', $url)->first();

        if($old != null)
        {
            error("Ya hay una categoria con el mismo nombre");
            return back();
        }

        $categoria              = new BlogCategoria();
        $categoria->titulo      = $request->titulo;
        $categoria->url         = $url;
        $categoria->empresa_id  = usuario('empresa');
        $categoria->save();

        registro(
            "info",
            usuario(),
            usuario('empresa'),
            "Blog",
            "Crear categoria",
            "Se crea categoria"
        );

        exito("La categoria se creo correctamente.");
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
        $categoria = BlogCategoria::find($id);

        if(($categoria == null) or (!control_empresa($categoria->empresa_id)))
        {
            error("Error al mostrar categoria");
            return back();
        }

        $entradas = $categoria->entradas;

        return view('plugins.blog.entrada.index', compact('entradas'));
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
        $categoria              = BlogCategoria::find($id);
        
        if(($categoria == null) or (!control_empresa($categoria->empresa_id)))
        {
            error('Error al actualizar categoria');
            return back();
        }

        $url = str_replace(" ", "_", strtolower($request->titulo));

        if($categoria->url != $url)
        {
            $old = Auth::user()->empresa->blogCategorias->where('url', $url)->first();

            if($old != null)
            {
                error("Ya hay una categoria con el mismo nombre");
                return back();
            }
        }

        $categoria->titulo      = $request->titulo;
        $categoria->url         = $url;
        $categoria->save();

        registro(
            "info",
            usuario(),
            usuario('empresa'),
            "Blog",
            "Editar categoria",
            "Se edita categoria"
        );

        exito("La categoria se modifico correctamente.");
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $categoria = BlogCategoria::find($id);

        if(($categoria == null) or (!control_empresa($categoria->empresa_id)))
        {
            error('Error al eliminar categoria');
            return back();
        }

        $categoria->delete();

        registro(
            "info",
            usuario(),
            usuario('empresa'),
            "Blog",
            "Eliminar categoria",
            "Se elimina categoria"
        );

        exito("La categoria se elimino correctamente.");
        return back();
    }
}
