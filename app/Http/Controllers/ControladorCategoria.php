<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Categoria;
use App\Models\Producto;
use Auth;
use Storage;
use File;

class ControladorCategoria extends Controller
{
    private $path = "admin.categoria.";

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categorias = Auth::user()->empresa->categorias;

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
        $old = Auth::user()->empresa->categorias->where('url', $url)->first();

        if($old != null)
        {
            error("Ya hay una categoria con el mismo nombre");
            return back();
        }

        $file       = $request->file('imagen');

        $categoria = new Categoria();

        if($file != null)
        {
            $nameFile   = codigo_aleatorio(10);

            Storage::disk('categoria')->put($nameFile.".".$file->getClientOriginalExtension(), File::get($file));

            $categoria->imagen = "storage/categoria/".$nameFile.".".$file->getClientOriginalExtension();
        }

        $categoria->titulo      = $request->titulo;
        $categoria->tipo        = "producto";
        $categoria->observacion = $request->observacion;
        $categoria->empresa_id  = usuario('empresa');
        $categoria->url         = $url;
        $categoria->save();

        registro(
            "info",
            usuario(),
            usuario('empresa'),
            "Categoria",
            "Crear",
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
        $categoria = Categoria::find($id);

        if(($categoria == null) or (!control_empresa($categoria->empresa_id)))
        {
            error('No se pudo mostrar categoria');
            return redirect('admin/categoria');
        }
        
        $productos = Producto::where('categoria_id', $id)->paginate(15);
        
        return view($this->path."show", compact('productos', 'categoria'));

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
        $categoria              = Categoria::find($id);
        
        if(($categoria == null) or (!control_empresa($categoria->empresa_id)))
        {
            error('No se pudo modificar la categoria');
            return back();
        }

        $url = str_replace(" ", "_", strtolower($request->titulo));

        if($categoria->url != $url)
        {
            $old = Auth::user()->empresa->categorias->where('url', $url)->first();

            if($old != null)
            {
                error("Ya hay una categoria con el mismo nombre");
                return back();
            }
        }

        $file       = $request->file('imagen');
        
        if($file != null)
        {
            if(file_exists($categoria->imagen))
                unlink($categoria->imagen);
            
            $nameFile   = codigo_aleatorio(10);

            Storage::disk('categoria')->put($nameFile.".".$file->getClientOriginalExtension(), File::get($file));

            $categoria->imagen = "storage/categoria/".$nameFile.".".$file->getClientOriginalExtension();
        }

        $categoria->titulo      = $request->titulo;
        $categoria->tipo        = "producto";
        $categoria->observacion = $request->observacion;
        $categoria->empresa_id  = usuario('empresa');
        $categoria->url         = $url;
        $categoria->save();

        exito("La categoria se modifico correctamente.");

        registro(
            "info",
            usuario(),
            usuario('empresa'),
            "Categoria",
            "Editar",
            "Se actualiza categoria"
        );

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
        $categoria = Categoria::find($id);

        if(($categoria == null) or (!control_empresa($categoria->empresa_id)))
        {
            error('Error al borrar categoria');
            return back();
        }

        foreach ($categoria->productos as $producto) 
        {
            $producto->categoria_id = null;
            $producto->save();
        }

        $categoria->delete();

        registro(
            "info",
            usuario(),
            usuario('empresa'),
            "Categoria",
            "Eliminar",
            "Se elimino categoria"
        );

        exito("La categoria se borro correctamente.");
        return back();  
    }

    public function borrar_imagen($id)
    {
        $categoria = Categoria::find($id);

        if(($categoria == null) or (!control_empresa($categoria->empresa_id)))
        {
            error("Error al borrar imagen.");
            return back();
        }

        if(file_exists($categoria->imagen))
            unlink($categoria->imagen);
        
        $categoria->imagen = null;
        $categoria->save();

        registro(
            "info",
            usuario(),
            usuario('empresa'),
            "Categoria",
            "Borrar Imagen",
            "Borrar imagen categoria"
        );

        exito("La imagen de la categoria se borro exitosamente.");
        return back();

    }
}
