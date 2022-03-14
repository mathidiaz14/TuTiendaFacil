<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Landing;
use App\Models\Tema;
use Auth;
use Storage;
use File;

class ControladorLanding extends Controller
{
    private $path = "admin.web.";

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $landings = Auth::user()->empresa->landings;

        return view($this->path."index", compact('landings'));
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
        $landings = Auth::user()->empresa->landings;

        if($landings == null)
        {
            error('Error al modificar los datos');
            return back();
        }

        foreach ($landings as $landing) 
        {
            if($landing->tipo == "imagen")
            {
                if($request[$landing->id] != null)
                {
                     $file       = $request->file($landing->id);

                    if($file != null)
                    {
                        if(file_exists($landing->valor))
                            unlink($landing->valor);
                        
                        $name       = $file->getClientOriginalName();
                        $nameFile   = codigo_aleatorio(15);

                        Storage::disk('public')->put($nameFile.".".$file->getClientOriginalExtension(), File::get($file));

                        $landing->valor = "storage/".$nameFile.".".$file->getClientOriginalExtension();
                        $landing->save(); 
                    }

                }
            }else
            {
                $landing->valor = $request[$landing->id];
                $landing->save();
            }
        }

        registro(
            "info",
            usuario(),
            usuario('empresa'),
            "Landing",
            "Modificar",
            "Se modifica landing"
        );

        exito("Los datos se modificaron correctamente.");
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
        $tipo       = "carpeta";
        $ruta       = resource_path('views/empresas/'.Auth::user()->empresa->id."/".Auth::user()->empresa->carpeta);
        $carpeta    = scandir($ruta);
        $atras      = "";

        return view($this->path."codigo", compact('carpeta', "tipo", "ruta", "atras"));

    }

    public function codigo(Request $request)
    {
        if($request->archivo == "")
        {
            $explode = explode('/',$request->ruta);

            $atras = "";
            
            for ($i=0; $i < count($explode) - 1 ; $i++) 
            {
                if($i < count($explode) - 2)
                    $atras .= $explode[$i]."/";
                else
                    $atras .= $explode[$i];
            } 

            $ruta = $request->ruta;

        }else
        {
            $atras  = $request->ruta; 
            $ruta   = $request->ruta."/".$request->archivo;
        }
        
        if(is_dir($ruta))
        {
            $tipo = "carpeta";
            $carpeta = scandir($ruta);

            return view($this->path."codigo", compact('carpeta', "tipo", "ruta", "atras"));
        }
        else
        {
            $tipo       = "archivo";
            $contenido  = file_get_contents($ruta);
            $explode    = explode('/',$ruta);
            $nombre     = $explode[count($explode)-1];

            return view($this->path."codigo", compact('contenido', "tipo", "ruta", "atras", "nombre"));
        }
    }

    public function guardar(Request $request)
    {

        if(($request->ruta == null) or ($request->contenido == null))
        {
            error('No se pudo modificar el archivo');
            return back();
        }

        file_put_contents($request->ruta, $request->contenido);

        $explode = explode('/',$request->ruta);

        $atras = "";
        
        for ($i=0; $i < count($explode) - 1 ; $i++) 
        {
            if($i < count($explode) - 2)
                $atras .= $explode[$i]."/";
            else
                $atras .= $explode[$i];
        } 

        $ruta = $request->ruta;
        
        $tipo       = "archivo";
        $contenido  = file_get_contents($ruta);
        $explode    = explode('/',$ruta);
        $nombre     = $explode[count($explode)-1];

        exito("El archivo se modifico correctamente");

        return view($this->path."codigo", compact('contenido', "tipo", "ruta", "atras", "nombre"));   

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
        //
    }

}
