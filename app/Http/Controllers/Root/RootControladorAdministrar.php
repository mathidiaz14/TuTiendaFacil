<?php

namespace App\Http\Controllers\Root;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RootControladorAdministrar extends Controller
{
    public function index()
    {
        $git  = shell_exec('git show');
        
        return view('root.administrar.index', compact('git'));
    }

    public function email(Request $request)
    {
        $contenido = [
            "titulo" => "Prueba desde el ROOT",
            "texto" => "Prueba de envio de correo desde la cuenta ROOT",
        ];
        
        email("email.prueba", "Prueba de envio de correo", $contenido, $request->email);

        exito('Se envio el correo');

        return back();
    }

    public function actualizar()
    {
        shell_exec('cd ~/apps/ttf');

        $respuesta  = shell_exec('git pull');

        exito('Respuesta desde el servidor: '.$respuesta);

        return back();
    }
}
