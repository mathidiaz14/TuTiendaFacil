<?php

namespace App\Http\Controllers\Root;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MensajeError;
use Auth;

class RootControladorMensajesError extends Controller
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
        $mensaje                = new MensajeError();
        $mensaje->usuario_id    = Auth::user()->id;
        $mensaje->error_id      = $request->error;
        $mensaje->mensaje       = $request->mensaje;
        $mensaje->estado        = "pendiente";
        $mensaje->save();

        $error = $mensaje->error;

        if($error->estado == "pendiente")
        {
            $error->estado = "tomado";
            $error->save();
        }

        crear_notificacion("Respuesta al error", "El administrador respondio a tu error", url('admin/error',$error->id), $error->usuario->empresa->id);

        $contenido = [
            'titulo' => "Respuesta en error",
            'mensaje' => $mensaje
        ];

        email("email.error.respuesta_administrador", "Respuesta en error #".$error->id, $contenido, $error->usuario->email);

        session(['exito' => "El mensaje se envio correctamente"]);
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
        $mensaje = MensajeError::find($id);
        $mensaje->delete();

        session(["exito" => "El mensaje se elimino correctamente"]);
        return back();
    }
}
