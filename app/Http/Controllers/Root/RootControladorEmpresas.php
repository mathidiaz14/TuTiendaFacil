<?php

namespace App\Http\Controllers\Root;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Empresa;
use App\Models\Venta;
use App\Models\Log;
use App\Models\User;
use App\Models\Configuracion;
use Carbon\Carbon;
use Auth;
use Hash;

class RootControladorEmpresas extends Controller
{
    private $path = "root.empresa.";

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $empresas = Empresa::paginate(20);

        return view($this->path."index", compact('empresas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view($this->path."create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $old = User::where('email', $request->usuario_email)->first();
        
        if($old != null)
        {
            error('El usuario ya esta registrado en nuestro sistema');
            return back();
        }

        $url    = "";
        $expira = "";
        $estado = "";

        if($request->plan == "plan1")
        {
            $url    = $request->url.".tutiendafacil.uy";
            $expira = Carbon::now()->addMonth();
            $estado = "creando";
        }
        else
        {
            $url    = $request->url;
            $expira = Carbon::now()->addYear();
            
            if($request->monto == 0)
                $estado = "creando";
            else
                $estado = "pendiente";
        }

        $empresa            = new Empresa();
        $empresa->nombre    = $request->nombre;
        $empresa->carpeta   = "default";
        $empresa->URL       = $url;
        $empresa->URL1      = "www.".$url;
        $empresa->plan      = $request->plan;
        $empresa->estado    = $estado;
        
        if($request->monto == 0)
            $empresa->pago  = "aprobado";

        $empresa->expira    = $expira;
        $empresa->monto     = $request->monto;
        $empresa->save();

        $usuario               = new User();
        $usuario->nombre       = $request->usuario_nombre;
        $usuario->email        = $request->usuario_email;
        
        if($request->usuario_contrasena != null)
            $usuario->password     = Hash::make($request->usuario_contrasena);

        $usuario->tipo         = "admin";
        $usuario->empresa_id   = $empresa->id;
        $usuario->save();
        
        instalar_tema_default($empresa);

        $configuracion              = new Configuracion();
        $configuracion->empresa_id  = $empresa->id;
        $configuracion->email_admin = $usuario->email;
        $configuracion->titulo      = "";
        $configuracion->descripcion = "";
        $configuracion->save();

        if($request->usuario_contrasena == null)
        {
            $token = codigo_aleatorio(30);
        
            $usuario->reset_password          = $token;
            $usuario->reset_password_expire   = Carbon::now()->addYear();
            $usuario->save();

            //Mail de bienvenida

            $contenido = [
                "titulo"        => "Bienvenido/a",
                "nombre"        => $usuario->nombre,
                "url"           => url('resetear/contrasena', $token)
            ];

            email("email.nueva_empresa.bienvenido_sin_contrasena", "Bienvenido/a a nuestra familia", $contenido, $usuario->email);
        }else
        {
            $contenido = [
                "titulo"        => "Bienvenido/a",
                "email"         => $usuario->email,
                "nombre"        => $usuario->nombre,
                "contrasena"    => $request->usuario_contrasena
            ];

            email("email.nueva_empresa.bienvenido_con_contrasena", "Bienvenido/a a nuestra familia", $contenido, $usuario->email);
        }

        registro(
            "info",
            usuario(),
            usuario('empresa'),
            "Empresa",
            "Crear",
            "Se crea la empresa #".$empresa->id
        );

        exito('La empresa se creo correctamente');

        return redirect('root/empresa');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $empresa    = Empresa::find($id);

        if($empresa == null)
        {
            error('La empresa no existe');
            return redirect('root/empresa');
        }

        $ventas     = Venta::where('empresa_id', $empresa->id)->paginate(20);
        $registros  = Log::where('empresa_id', $empresa->id)->orderBy('created_at', 'desc')->paginate(20);

        return view($this->path."show", compact('empresa', 'ventas', 'registros'));   
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

        $empresa            = Empresa::find($id);
        $empresa->nombre    = $request->nombre;
        $empresa->RUT       = $request->rut;
        $empresa->URL       = $request->URL;
        $empresa->URL1      = $request->URL1;
        $empresa->URL2      = $request->URL2;
        $empresa->URL3      = $request->URL3;
        $empresa->estado    = $request->estado;
        $empresa->plan      = $request->plan;
        $empresa->expira    = $request->expira;
        $empresa->save();

        exito('La empresa se modifico correctamente');

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
        $empresa = Empresa::find($id);
        
        $empresa->productos()->delete();
        $empresa->clientes()->delete();
        $empresa->categorias()->delete();
        $empresa->proveedores()->delete();
        $empresa->ventas()->delete();
        $empresa->configuracion()->delete();
        $empresa->multimedia()->delete();
        $empresa->mensajes()->delete();
        $empresa->notificaciones()->delete();
        $empresa->paginas()->delete();
        $empresa->locales()->delete();
        $empresa->usuarios()->delete();
        $empresa->visitas()->delete();
        $empresa->landings()->delete();
        $empresa->plugins()->delete();
        $empresa->temas()->delete();
        $empresa->newsletters()->delete();
        $empresa->errores()->delete();
        $empresa->cupones()->delete();
        $empresa->registros()->delete();
        $empresa->blogCategorias()->delete();
        $empresa->blogComentarios()->delete();
        $empresa->blogEntradas()->delete();
        $empresa->ventaPorWpp()->delete();

        $empresa->delete();

        exito('La empresa se elimino correctamente');

        return back();

    }

    public function control($id, Request $request)
    {
        $empresa = Empresa::find($id);

        if($empresa->control_codigo == $request->codigo)
        {
            $now = now();

            if($now->diffInMinutes($empresa->control_hora) <= 15)
            {
                $usuario = User::find($empresa->control_usuario);

                Auth::login($usuario, true);

                return redirect('admin'); 

            }else
            {
                error('El codigo se genero hace mas de 15 minutos');
            }

        }else
        {
            error('El codigo no coincide con el de la empresa');
        }

        return back();
    }

    public function deshabilitar($id)
    {
        $empresa = Empresa::find($id);

        if($empresa == null)
        {
            error("La empresa no existe");
            return back();
        }

        if($empresa->estado != "deshabilitado")
        {
            $empresa->estado = "deshabilitado";
            $empresa->save();

        }else
        {
            $empresa->estado = "completo";
            $empresa->save();
        }
        
        exito("La empresa se deshabilito correctamente");
        return back();
    }
}
