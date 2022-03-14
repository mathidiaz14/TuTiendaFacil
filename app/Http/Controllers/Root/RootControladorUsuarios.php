<?php

namespace App\Http\Controllers\Root;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Log;
use Hash;
use Auth;

class RootControladorUsuarios extends Controller
{
    private $path = "root.usuario.";

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $usuarios = User::paginate(20);

        return view($this->path."index", compact('usuarios'));
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
        $usuario = User::find($id);

        $registros = Log::where('empresa_id', $usuario->empresa_id)->paginate(20);

        return view($this->path."show", compact('usuario', 'registros'));
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
        $usuario            = User::find($id);
        $usuario->nombre    = $request->nombre;
        $usuario->email     = $request->email;
        $usuario->ci        = $request->ci;

        if($request->contrasena != null)
            $usuario->password = Hash::make($request->contrasena);

        $usuario->save();

        Session(['exito' => 'El usuario se modifico correctamente']);

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
        $usuario = User::find($id);

        $usuario->delete();

        Session(['exito' => 'El usuario se elimino correctamente']);

        return back();
    }

    public function get_perfil()
    {
        $usuario = Auth::user();

        return view($this->path."perfil", compact('usuario'));
    }

    public function ser_perfil(Request $request)
    {
        $usuario = Auth::user();

        $usuario->nombre = $request->nombre;
        $usuario->ci = $request->ci;

        if($request->contrasena != null)
        {
            if($request->contrasena === $request->repetir_contrasena)
            {
                if(strlen($request->contrasena) < 8)
                {
                    Session(['error' => "La contraseña debe tener al menos 8 caracteres"]);
                    return back();
                }
                
                $usuario->password = Hash::make($request->contrasena);
            }else
            {
                Session(['error' => "Las contraseñas no coinciden."]);
                return back();
            }
        }

        $usuario->save();

        Session(['exito' => "Los datos se modificaron correctamente."]);
        return back();
    }
}
