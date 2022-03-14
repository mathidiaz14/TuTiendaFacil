<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Auth;
use Hash;

class ControladorUsuario extends Controller
{
    private $path = "admin.usuario.";

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $usuarios = Auth::user()->empresa->usuarios;

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
        $flag = true;

        if((Auth::user()->empresa->plan == "plan1") and (Auth::user()->empresa->usuarios->count() >= 1))
            $flag = false;
        elseif((Auth::user()->empresa->plan == "plan2") and (Auth::user()->empresa->usuarios->count() >= 2))
            $flag = false;


        if(!$flag)
        {
            error("Ha llegado al limite de usuarios para su plan");
            return back();
        }

        $old = User::where('email', $request->email)->first();

        if($old != null)
        {
            error("El correo electronico ya esta registrado para otro usuario");
            return back();
        }

        $usuario                = new User();
        $usuario->nombre        = $request->nombre;
        $usuario->email         = $request->email;
        $usuario->ci            = $request->ci;
        $usuario->tipo          = "admin";
        $usuario->empresa_id    = Auth::user()->empresa_id;
        $usuario->password      = Hash::make($request->contrasena);
        $usuario->save();

        registro(
            "info",
            usuario(),
            usuario('empresa'),
            "Usuario",
            "Agregar",
            "Se agrega usuario"
        );

        exito("El usuario se creo correctamente.");
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
        $usuario            = User::find($id);
        
        if(($usuario == null) or (!control_empresa($usuario->empresa_id)))
        {
            error("Error al editar usuario");
            return back();
        }

        $usuario->nombre    = $request->nombre;
        $usuario->ci        = $request->ci;
        $usuario->tipo      = "admin";
        $usuario->save();

        registro(
            "info",
            usuario(),
            usuario('empresa'),
            "Usuario",
            "Editar",
            "Se modifico usuario"
        );

        exito("El usuario se modifico correctamente.");
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
        
        if(($usuario == null) or (!control_empresa($usuario->empresa_id)))
        {
            error("Error al eliminar usuario");
            return back();
        }

        $usuario->delete();

        registro(
            "info",
            usuario(),
            usuario('empresa'),
            "Usuario",
            "Eliminar",
            "Se elimino usuario"
        );

        exito("El usuario se elimino correctamente.");
        return back();
    }

    public function ver_perfil()
    {
        $usuario = Auth::user();

        if($usuario == null)
        {
            error('Error al mostrar usuario');
            return back();
        }

        return view($this->path."perfil", compact('usuario'));
    }

    public function perfil(Request $request)
    {
        $usuario            = Auth::user();
        $usuario->nombre    = $request->nombre;
        $usuario->ci        = $request->ci;

        if($request->contrasena != null)
        {
            if($request->contrasena === $request->repetir_contrasena)
            {
                if(strlen($request->contrasena) < 8)
                {
                    error("La contraseña debe tener al menos 8 caracteres");
                    return back();
                }
                
                $usuario->password = Hash::make($request->contrasena);
            }else
            {
                error("Las contraseñas no coinciden.");
                return back();
            }
        }

        $usuario->save();

        registro(
            "info",
            usuario(),
            usuario('empresa'),
            "Usuario",
            "Editar",
            "Se modifico usuario"
        );
        
        exito("Los datos se modificaron correctamente.");
        return back();
    }
}
