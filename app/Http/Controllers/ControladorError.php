<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Error;
use App\Models\MensajeError;
use Storage;
use File;
use Auth;
use Response;

class ControladorError extends Controller
{
    private $path = "admin.error.";

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $errores = Auth::user()->errores;

        return view($this->path."index", compact('errores'));
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
        $file               = $request->file('adjunto');

        $error              = new Error();
        
        $error->user_id     = usuario();
        $error->pantalla    = $request->pantalla;
        $error->mensaje     = $request->mensaje;
        $error->captura     = $request->captura;
        $error->estado      = "pendiente";
        
        if($file != null)
        {
            $nameFile = "error_".codigo_aleatorio(10).".".$file->getClientOriginalExtension();
            
            Storage::disk('error')->put($nameFile, File::get($file));
            $error->adjunto     = "storage/error/".$nameFile;
        }
        
        $error->save();

        $contenido=[
            'titulo' => "Nueva incidencia registrada",
            'error' => $error
        ];

        email(
            'email.error.nuevo', 
            "Nueva incidencia registrada", 
            $contenido, 
            'admin@tutiendafacil.uy'
        );

        registro(
            "info",
            usuario(),
            usuario('empresa'),
            "Error",
            "Crear",
            "Se creo el error "
        );

        exito('La incidecia se registro correctamente.');
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
        $error = Error::find($id);

        if(($error == null) or ($error->user_id != usuario()))
        {
            error('Error al mostrar el registro');
            return back();
        }

        foreach ($error->mensajes as $mensaje)
        {
            $mensaje->estado = "leido";
            $mensaje->save();
        }

        return view($this->path."show", compact('error'));
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
        $error = Error::find($id);

        if(($error == null) or ($error->user_id != usuario()))
        {
            error('Error al eliminar la incidencia');
            return back();
        }

        if(($error->adjunto != null) and (file_exists($error->adjunto)))
            unlink($error->adjunto);

        $error->mensajes()->delete();
        $error->delete();

        exito('La incidencia se elimino correctamente');
        return back();
    }

    public function responder($id, Request $request)
    {
        $mensaje                = new MensajeError();

        if(($mensaje == null) or (!control_empresa($mensaje->empresa_id)))
        {
            error('Error al responder el mensaje');
            return back();
        }

        $mensaje->usuario_id    = usuario();
        $mensaje->error_id      = $id;
        $mensaje->mensaje       = $request->mensaje;
        $mensaje->estado        = "pendiente";
        $mensaje->save();

        $contenido = [
            'titulo' => "Respuesta en error",
            'error' => $mensaje
        ];

        email("email.error.respuesta", "Respuesta en error #".$mensaje->error->id, $contenido, "admin@tutiendafacil.uy");

        registro(
            "info",
            usuario(),
            usuario('empresa'),
            "Error",
            "Responder",
            "Se respondio error "
        );

        exito("Su respuesta fue enviada correctamente");
        return back();
        
    }

    public function captura($id)
    {
        $error = Error::find($id);

        if(($error != null) and ($error->captura != null) and ($error->usuario->id == Auth::user()->id))
            return view($this->path."captura", compact('error'));

        error('No es posible visualizar la captura');
        return back();
    }

    public function adjunto($id)
    {
        $error = Error::find($id);

        if(($error != null) and ($error->adjunto != null) and ($error->usuario->id == Auth::user()->id))
            return Response::download($error->adjunto);

        error('No es posible descargar el adjunto');
        return back();
    }

    public function soporte()
    {
        return view($this->path."chat");
    }
}
