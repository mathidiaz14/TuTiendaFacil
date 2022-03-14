<?php

namespace App\Http\Controllers\Plugins\Blog;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Plugins\Blog\BlogEntrada;
use App\Models\Plugins\Blog\BlogEntradaRegistro;
use Auth;
use Storage;
use File;

class BlogControladorEntrada extends Controller
{
    private $path = "plugins.blog.entrada.";

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $entradas = Auth::user()->empresa->blogEntradas;

        return view($this->path."index", compact('entradas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view($this->path."create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $old = BlogEntrada::where('url', $request->url)->first();

        if($old != null)
        {
            error("Ya existe una entrada con esta nombre, prueba cambiarlo e intenta nuevamente.");
            return back();
        }

        $entrada = new BlogEntrada();
        
        $file       = $request->file('imagen');

        if($file != null)
        {
            $nameFile   = codigo_aleatorio(10).".".$file->getClientOriginalExtension();

            Storage::disk('blog')->put($nameFile, File::get($file));

            $entrada->imagen = "storage/blog/".$nameFile;
        }

        $entrada->titulo            = $request->titulo;
        $entrada->url               = $request->url;
        $entrada->contenido         = $request->contenido;
        $entrada->extracto          = $request->extracto;
        $entrada->meta_descripcion  = $request->meta_descripcion;
        $entrada->meta_tags         = $request->meta_tags;
        $entrada->estado            = $request->estado;
        $entrada->categoria_id      = $request->categoria;
        $entrada->comentario_activo = $request->comentario_activo;
        $entrada->empresa_id        = Auth::user()->empresa->id;
        $entrada->user_id           = Auth::user()->id;
        $entrada->save();

        registro(
            "info",
            usuario(),
            usuario('empresa'),
            "Blog",
            "Crear entrada",
            "Se crea entrada"
        );

        exito("La entrada se creo correctamente.");
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $entrada = BlogEntrada::find($id);

        if(($entrada == null) or (!control_empresa($entrada->empresa_id)))
        {
            error('Error al editar entrada');
            return back();
        }

        return view($this->path."edit", compact('entrada'));
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
        $entrada    = BlogEntrada::find($id);

        if(($entrada == null) or (!control_empresa($entrada->empresa_id)))
        {
            error('Error al actualizar entrada');
            return back();
        }

        $old        = BlogEntrada::where('url', $request->url)->first();

        if(($old != null) and ($old->id != $entrada->id))
        {
            error("Ya existe una entrada con esta nombre, prueba cambiarlo e intenta nuevamente.");
            return back();
        }

        $file       = $request->file('imagen');

        if($file != null)
        {
            if(file_exists($entrada->imagen))
                unlink($entrada->imagen);

            $nameFile   = codigo_aleatorio(10).".".$file->getClientOriginalExtension();

            Storage::disk('blog')->put($nameFile, File::get($file));

            $entrada->imagen = "storage/blog/".$nameFile;
        }

        $entrada->titulo            = $request->titulo;
        $entrada->url               = $request->url;
        $entrada->contenido         = $request->contenido;
        $entrada->extracto          = $request->extracto;
        $entrada->meta_descripcion  = $request->meta_descripcion;
        $entrada->meta_tags         = $request->meta_tags;
        $entrada->estado            = $request->estado;
        $entrada->categoria_id      = $request->categoria;
        $entrada->comentario_activo = $request->comentario_activo;
        $entrada->save();

        $registro               = new BlogEntradaRegistro();
        $registro->entrada_id   = $entrada->id;
        $registro->user_id      = usuario();
        $registro->save();

        registro(
            "info",
            usuario(),
            usuario('empresa'),
            "Blog",
            "Editar entrada",
            "Se edita entrada"
        );

        exito("La entrada se creo correctamente.");
        return redirect('admin/blog/entrada');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $entrada = BlogEntrada::find($id);
        
        if(($entrada == null) or (!control_empresa($entrada->empresa_id)))
        {
            error('Error al eliminar entrada');
            return back();
        }

        $entrada->comentarios()->delete();
        $entrada->delete();

        registro(
            "info",
            usuario(),
            usuario('empresa'),
            "Blog",
            "Eliminar entrada",
            "Se elimina entrada"
        );

        exito("La entrada se elimino correctamente");
        return back();
    }
}
