<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notificacion;
use Auth;

class ControladorNotificacion extends Controller
{
    private $path = "admin.notificacion.";

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {       
        $notificaciones = Notificacion::where('empresa_id', Auth::user()->empresa_id)
                                    ->orderBydesc('created_at')
                                    ->paginate(20);

        return view($this->path."index", compact('notificaciones'));
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
        $notificacion = Notificacion::find($id);

        if(($notificacion == null) or (!control_empresa($notificacion->empresa_id)))
        {
            error('Error al mostrar notificación');
            return back();
        }

        $notificacion->estado = "leido";
        $notificacion->save();

        return redirect($notificacion->url);
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
        $notificacion = Notificacion::find($id);

        if(($notificacion == null) or (!control_empresa($notificacion->empresa_id)))
        {
            error('Error al eliminar notificación');
            return back();
        }

        $notificacion->delete();

        exito('La notificacion se elimino correctamente.');
        return back();
    }

    public function pendiente()
    {
        $notificaciones = Auth::user()->empresa->notificaciones->where('estado', 'pendiente');

        foreach($notificaciones as $notificacion)
        {
            $notificacion->estado = "noleido";
            $notificacion->save();
        }

        return true;
    }

    public function cargar_notificacion()
    {
        if(Auth::check())
        {
            $todas      = Auth::user()->empresa->notificaciones;
            $nuevas     = Auth::user()->empresa->notificaciones->where('estado', 'nuevo');
            $pendiente  = Auth::user()->empresa->notificaciones->where('estado', 'pendiente')->count() + $nuevas->count();
            
            return view('layouts.partes.notificaciones', compact('todas', 'nuevas', 'pendiente'));
        }
    }
}
