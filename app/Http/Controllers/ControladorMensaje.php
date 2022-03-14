<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mensaje;
use Auth;

class ControladorMensaje extends Controller
{
    private $path = "admin.mensaje.";

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $mensajes = Mensaje::where('empresa_id', Auth::user()->empresa_id)
                                    ->where('padre_id', null)
                                    ->orderBydesc('created_at')
                                    ->paginate(20);

        return view($this->path."index", compact('mensajes'));
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
        $mensaje            = Mensaje::find($id);
        $mensaje->estado    = "leido";
        $mensaje->save();

        return redirect('admin/mensaje');
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
        $old = Mensaje::find($id);

        if($old == null)
        {
            error('Error al responder responder mensaje');
            return back();
        }

        $mensaje                = new Mensaje();
        $mensaje->nombre        = "Respuesta";
        $mensaje->email         = "Respuesta";
        $mensaje->contenido     = $request->respuesta;
        $mensaje->padre_id      = $old->id;
        $mensaje->save();

        registro(
            "info",
            usuario(),
            usuario('empresa'),
            "Mensaje",
            "Responder",
            "Se responde mensaje"
        );

        $contenido = [
            "titulo"    => "Respuesta a tu consulta",
            "respuesta" => $mensaje->contenido,
        ];

        email('email.mensaje.respuesta', "Respuesta a tu consulta en ".$old->empresa->nombre, $contenido, $old->email);

        exito('El mensaje se envio correctamente.');
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
        $mensaje = Mensaje::find($id);
        
        if($mensaje == null)
        {
            error('No se pudo eliminar el mensaje');
            return back();
        }

        $mensaje->hijos()->delete();
        $mensaje->delete();

        registro(
            "info",
            usuario(),
            usuario('empresa'),
            "Mensaje",
            "Eliminar",
            "Se elimina mensaje"
        );

        exito('El mensaje se elimino correctamente.');
        return back();
    }

    public function pendiente()
    {
        $mensajes = Auth::user()->empresa->mensajes->where('estado', 'pendiente');

        foreach($mensajes as $mensaje)
        {
            $mensaje->estado = "noleido";
            $mensaje->save();
        }

        return true;
    }

    public function cargar_mensaje()
    {
        if(Auth::check())
        {
            $todos      = Auth::user()->empresa->mensajes;
            $nuevos     = Auth::user()->empresa->mensajes->where('estado', 'nuevo');
            $pendiente  = Auth::user()->empresa->mensajes->where('estado', 'pendiente')->count() + $nuevos->count();
            
            return view('layouts.partes.mensajes', compact('todos', 'nuevos', 'pendiente'));
        }
    }
}
