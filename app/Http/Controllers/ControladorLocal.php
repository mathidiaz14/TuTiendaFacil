<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Local;
use Auth;

class ControladorLocal extends Controller
{
    private $path = "admin.local.";

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $locales = Auth::user()->empresa->locales;

        return view("admin.configuracion.locales", compact('locales'));
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
        $local = new Local();
        $local->empresa_id  = Auth::user()->empresa_id;
        $local->nombre      = $request->nombre;
        $local->direccion   = $request->direccion;
        $local->localidad   = $request->localidad;
        $local->save();

        registro(
            "info",
            usuario(),
            usuario('empresa'),
            "Local",
            "Agregar",
            "Se agrega local"
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
        $local = Local::find($id);
        
        if(($local == null) or (control_empresa($local->empresa_id)))
        {
            error('No se pudo modificar el local');
            return back();
        }

        $local->nombre      = $request->nombre;
        $local->direccion   = $request->direccion;
        $local->localidad   = $request->localidad;
        $local->save();

        registro(
            "info",
            usuario(),
            usuario('empresa'),
            "Local",
            "Modificar",
            "Se modifica local"
        );

        exito("El local se modifico correctamente.");

        return redirect('admin/configuracion?envio');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $local = Local::find($id);

        if(!control_empresa($local->empresa_id))
        {
            error('No se pudo borrar el local');
            return back();
        }
        
        $local->delete();
        
        registro(
            "info",
            usuario(),
            usuario('empresa'),
            "Local",
            "Eliminar",
            "Se elimina local"
        );

        exito("El local se elimino correctamente.");
        return redirect('admin/configuracion?envio');
    }
}
