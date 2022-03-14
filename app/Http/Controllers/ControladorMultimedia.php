<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Multimedia;
use App\Models\Producto;
use File;
use Storage;
use Auth;

class ControladorMultimedia extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        $file       = $request->file('file');
        
        if($file == null)
            return false;

        $name       = $file->getClientOriginalName();
        $nameFile   = codigo_aleatorio(20).".".$file->getClientOriginalExtension();

        Storage::disk('public')->put($nameFile, File::get($file));

        $media              = new Multimedia();
        $media->url         = "storage/".$nameFile;
        $media->nombre      = $name;
        $media->empresa_id  = usuario('empresa');
        $media->producto_id = $request->producto;
        $media->save();

        registro(
            "info",
            usuario(),
            usuario('empresa'),
            "Multimedia",
            "Agregar",
            "Se guardo imagen"
        );

        return true;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $producto = Producto::find($id);

        if(($producto == null) or (!control_empresa($producto->empresa_id)))
        {
            error('Error al cargar los archivos multimedia');
            return back();
        }

        $multimedia = $producto->multimedia;
        return view('admin.multimedia.index', compact('multimedia'));
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $multimedia = Multimedia::find($id);

        if(($multimedia == null) or (!control_empresa($multimedia->empresa_id)))
        {
            error('Error al eliminar el archivo');
            return back();
        }
        
        if(file_exists($multimedia->url))
            unlink($multimedia->url);
        
        $multimedia->delete();

        registro(
            "info",
            usuario(),
            usuario('empresa'),
            "Multimedia",
            "Eliminar",
            "Se elimino imagen"
        );

        return true;
    }

    public function principal(Request $request)
    {
        $multimedia = Multimedia::find($request->id);

        if(($multimedia == null) or (!control_empresa($multimedia->empresa_id)))
        {
            error('Error al colocar imagen como principal');
            return back();
        }
        
        $producto = $multimedia->producto;

        foreach($producto->multimedia as $imagen)
        {
            $imagen->tipo = null;
            $imagen->save();
        }

        $multimedia->tipo = "principal";
        $multimedia->save();
        
        return true;
    }

}
