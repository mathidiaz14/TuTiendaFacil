<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Configuracion;
use Auth;
use Http;
use Storage;
use File;

class ControladorConfiguracion extends Controller
{
    private $path = "admin.configuracion.";

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $configuracion  = Auth::user()->empresa->configuracion;
        $locales        = Auth::user()->empresa->locales;

        return view($this->path."index", compact('configuracion', 'locales'));
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
        //
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
        $configuracion  = Configuracion::find($id);
        
        if(($configuracion == null) or (!control_empresa($configuracion->empresa_id)))
        {
            error('No se pudo modificar la configuración, contacte al administrador');
            return back();
        }

        $file           = $request->file('logo');

        if($file != null)
        {
            $nameFile   = codigo_aleatorio(10);

            Storage::disk('public')->put($nameFile.".".$file->getClientOriginalExtension(), File::get($file));

            $configuracion->logo = "storage/".$nameFile.".".$file->getClientOriginalExtension();
        }

        $configuracion->titulo                  = $request->titulo;
        $configuracion->descripcion             = $request->descripcion;
        $configuracion->email_admin             = $request->email_admin;
        $configuracion->telefono                = $request->telefono;
        $configuracion->construccion            = $request->construccion;
        $configuracion->envio                   = $request->envio;
        $configuracion->retiro                  = $request->retiro;
        $configuracion->efectivo_estado         = $request->efectivo_estado;
        $configuracion->transferencia_estado    = $request->transferencia_estado;
        $configuracion->transferencia_cuenta    = $request->transferencia_cuenta;
        $configuracion->transferencia_contacto  = $request->transferencia_contacto;

        $configuracion->save();

        registro(
            "info",
            usuario(),
            usuario('empresa'),
            "Configuración",
            "Editar",
            "Se edita configuración"
        );

        exito("Información modificada correctamente");
        
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
        //
    }

    public function eliminar_logo()
    {
        $configuracion = Auth::user()->empresa->configuracion;

        if($configuracion == null)
        {
            error('No se pudo eliminar el logo');
            return back();
        }

        if(file_exists($configuracion->logo))
            unlink($configuracion->logo);
        
        $configuracion->logo = null;
        $configuracion->save();


        registro(
            "info",
            usuario(),
            usuario('empresa'),
            "Configuración",
            "Eliminar logo",
            "Se elimina logo"
        );

        exito("El logo se elimino correctamente");
        return back();
    }
}
