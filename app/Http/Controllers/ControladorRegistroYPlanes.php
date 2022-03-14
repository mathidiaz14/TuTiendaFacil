<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Empresa;
use App\Models\Configuracion;
use App\Models\Codigo;
use Carbon\Carbon;
use Auth;
use File;
use Session;
use MercadoPago;
use Hash;

class ControladorRegistroYPlanes extends Controller
{

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials, $request->remember)) 
        {
            registro(
                "login",
                usuario(),
                usuario('empresa'),
                "Login",
                "Login",
                "El usuario inicio sesión"
            );

            if($request->redirect != null)
                return redirect($request->redirect);
                
            return redirect('admin'); 
        
        }

        error('Usuario o contraseña incorrectos');
        return back();
    }
    
    public function ver_reseteo_contrasena_envio()
    {
        return view('auth.forgot-password');
    }

    public function reseteo_contrasena_envio(Request $request)
    {
    	$user = User::where('email', $request->email)->first();

        if($user == null)
        {
            error("El email que ingreso no se encuentra en nuestra base de datos.");
            return back();
        }

    	$token = codigo_aleatorio(30);
    	
    	$user->reset_password          = $token;
    	$user->reset_password_expire   = Carbon::now()->addDay();
    	$user->save();

    	$contenido = [
            "titulo" => "Reseteo de contraseña",
            "url" => url('resetear/contrasena', $token),
        ];
    	
    	email("email.contrasena.reset", "Reseteo de contraseña - TuTiendaFacil.uy", $contenido, $user->email);
    	
        registro(
            "info",
            $user->id,
            $user->empresa_id,
            "Login",
            "Contraseña",
            "Se solicito el reseteo de contraseña"
        );

    	exito("Se envió un email para el reseteo de la contraseña, el link será valido por 24 horas.");
    	return back();
    }
    
    public function ver_reseteo_contrasena($id)
    {
    	$user = User::where('reset_password', $id)->first();

    	if($user == null)
        {
    		error('Error al mostrar pagina');
            return redirect('login');
        }

    	if(Carbon::now()->diffInHours($user->reset_password_expire) <= 0)
    	{
    		error("El link que utilizo ya no está disponible, realice nuevamente el procedimiento para resetear la contraseña.");
    		return view('auth.forgot-password');
    	}

    	return view('auth.reset-password', compact('user'));
    }

    public function reseteo_contrasena(Request $request)
    {
    	$user = User::find($request->user);
    	
    	if($user == null)
        {
            error('Error al resetear contraseña');
            return view('auth.login');
        }

        if($request->password != $request->re_password)
        {
            error('Las contraseñas no coinciden, intente de nuevo por favor.');
            return back();
        }

        if(strlen($request->password) < 8)
        {
            error('La contraseña debe tener al menos 8 caracteres.');
            return back();   
        }

        $user->password                 = Hash::make($request->password);
        $user->reset_password           = null;
        $user->reset_password_expire    = null;
        $user->save();

        registro(
            "info",
            $user->id,
            $user->empresa_id,
            "Login",
            "Contraseña",
            "Se reseteo la contraseña"
        );

        exito('La contraseña se modifico correctamente.');
        return redirect('/admin'); 
    }

    public function ver_registrarse()
    {
        return view('auth.register');
    }

    public function registrarse(Request $request)
    {
        $old = User::where('email', $request->email)->first();

        if($old != null)
        {
            error('Esta cuenta de correo electronico ya esta registrada en nuestro sistema.');
            return back()->withInput();   
        }

        if($request->password !== $request->repassword)
        {
            error('Las contraseñas no coinciden, intente de nuevo por favor.');
            return back()->withInput();
        }

        if(strlen($request->password) < 8)
        {
            error('La contraseña debe tener al menos 8 caracteres.');
            return back()->withInput();   
        }   

        $usuario = collect([ 
            "nombre"    => $request->name,
            "email"     => $request->email,
            "plan"      => $request->plan,
            "password"  => Hash::make($request->password)
        ]);

        session(['usuario' => $usuario]);

        if($request->plan == "plan1")
            return view('auth.planes.plan1');
        else if($request->plan == "plan2")
            return view('auth.planes.plan2');
        else
            return view('auth.planes.plan3');
    }

    public function plan1(Request $request)
    {
        $codigo = $this->comprobar_codigo($request->codigo, 'plan1');

        if($codigo == "total")
        {
            $pago = "aprobado";
            $expira = Carbon::now()->addYear();
        }else
        {
            $pago = "prueba";
            $expira = Carbon::now()->addDays(30);
        }

        $empresa = collect([ 
            "nombre"        => $request->nombre,
            "url"           => $request->url.".tutiendafacil.uy",
            "titulo"        => $request->titulo,
            "descripcion"   => $request->descripcion,
            "plan"          => "plan1",
            "expira"        => $expira,
        ]);

        session(['empresa' => $empresa]);

        $this->crear_empresa('creando', $pago, '');

        return view('auth.planes.pago_exitoso');
    }

    public function plan2(Request $request)
    {
        $usuario        = session('usuario');        
        $monto          = opcion($usuario['plan']);
        $descripcion    = "Plan avanzado - TuTiendaFacil.uy";
        $codigo         = $this->comprobar_codigo($request->codigo, $usuario['plan']);

        if($codigo != "no")
        {
            if($codigo == "error1")
            {
                error("El codigo ingresado no existe, pruebe nuevamente");
                return back()->withInput();
            
            }elseif($codigo == "error2")
            {
                error("El codigo que esta utilizando esta asignado para otro usuario");
                return back()->withInput();

            }elseif($codigo == "error3")
            {
                error("Ese codigo no es para este plan, pruebe nuevamente");
                return back()->withInput();

            }elseif($codigo == "total")
            {
                $empresa = collect([ 
                    "nombre"        => $request->nombre,
                    "url"           => $request->url.$request->extension,
                    "titulo"        => $request->titulo,
                    "descripcion"   => $request->descripcion,
                    "plan"          => $usuario['plan'],
                    "expira"        => Carbon::now()->addYear(),
                ]);

                session(['empresa' => $empresa]);

                $this->crear_empresa('creando', 'aprobado', '');

                return view('auth.planes.pago_exitoso');
            
            }else
            {
                $monto = opcion($usuario['plan']) * ((100 - (int)$codigo) / 100);
            }
        }
        
        $empresa = collect([ 
            "nombre"        => $request->nombre,
            "url"           => $request->url.$request->extension,
            "titulo"        => $request->titulo,
            "descripcion"   => $request->descripcion,
            "plan"          => $usuario['plan'],
            "expira"        => Carbon::now()->addYear(),
        ]);

        session(['empresa' => $empresa]);

        MercadoPago\SDK::setAccessToken(env('MP_ACCESS_TOKEN'));

        $preference = new MercadoPago\Preference();

        $item                           = new MercadoPago\Item();
        $item->title                    = $descripcion;
        $item->quantity                 = 1;
        $item->currency_id              = "UYU";
        $item->unit_price               = $monto;
        $preference->items              = array($item);
        $preference->back_urls          = array(
                                            "success" => url('registrar/pago/exitoso'),
                                            "failure" => url('registrar/pago/fallido'),
                                            "pending" => url('registrar/pago/pendiente')
                                        );
        $preference->auto_return        = "approved"; 
        $preference->save();

        return view('auth.planes.pago', compact('monto', 'descripcion', 'preference', 'empresa', 'usuario'));
    }

    public function plan3(Request $request)
    {
        $usuario        = session('usuario');        
        $monto          = opcion($usuario['plan']);
        $descripcion    = "Plan Profesiónal - TuTiendaFacil.uy";
        $codigo         = $this->comprobar_codigo($request->codigo, $usuario['plan']);

        if($codigo != "no")
        {
            if($codigo == "error1")
            {
                error("El codigo ingresado no existe, pruebe nuevamente");
                return back()->withInput();
            
            }elseif($codigo == "error2")
            {
                error("El codigo que esta utilizando esta asignado para otro usuario");
                return back()->withInput();

            }elseif($codigo == "error3")
            {
                error("Ese codigo no es para este plan, pruebe nuevamente");
                return back()->withInput();

            }elseif($codigo == "total")
            {
                $empresa = collect([ 
                    "nombre"        => $request->nombre,
                    "url"           => $request->url.$request->extension,
                    "titulo"        => $request->titulo,
                    "descripcion"   => $request->descripcion,
                    "plan"          => $usuario['plan'],
                    "expira"        => Carbon::now()->addYear(),
                ]);

                session(['empresa' => $empresa]);

                $this->crear_empresa('creando', 'aprobado', '');

                return view('auth.planes.pago_exitoso');
            
            }else
            {
                $monto = opcion($usuario['plan']) * ((100 - (int)$codigo) / 100);
            }
        }
        
        $empresa = collect([ 
            "nombre"        => $request->nombre,
            "url"           => $request->url.$request->extension,
            "titulo"        => $request->titulo,
            "descripcion"   => $request->descripcion,
            "plan"          => $usuario['plan'],
            "expira"        => Carbon::now()->addYear(),
        ]);

        session(['empresa' => $empresa]);

        MercadoPago\SDK::setAccessToken(env('MP_ACCESS_TOKEN'));

        $preference = new MercadoPago\Preference();

        $item                           = new MercadoPago\Item();
        $item->title                    = $descripcion;
        $item->quantity                 = 1;
        $item->currency_id              = "UYU";
        $item->unit_price               = $monto;
        $preference->items              = array($item);
        $preference->back_urls          = array(
                                            "success" => url('registrar/pago/exitoso'),
                                            "failure" => url('registrar/pago/fallido'),
                                            "pending" => url('registrar/pago/pendiente')
                                        );
        $preference->auto_return        = "approved"; 
        $preference->save();

        return view('auth.planes.pago', compact('monto', 'descripcion', 'preference', 'empresa', 'usuario'));
    }    

    public function comprobar_url($plan, $id)
    {
        if($plan == "plan1")
        {
            $string = $id.".tutiendafacil.uy";
            
            $empresa = Empresa::where('URL', 'LIKE', $string)->first();

            if($empresa == null)
                $empresa = Empresa::where('URL1', 'LIKE', $string)->first();

            if($empresa == null)
                $empresa = Empresa::where('URL2', 'LIKE', $string)->first();

            if($empresa == null)
                $empresa = Empresa::where('URL3', 'LIKE', $string)->first();
            
            if($empresa != null)
                return "no";
            else
                return "si";
        }else
        {
            $empresa = Empresa::where('URL', 'LIKE', $id)->first();

            if($empresa == null)
                $empresa = Empresa::where('URL1', 'LIKE', $id)->first();

            if($empresa == null)
                $empresa = Empresa::where('URL2', 'LIKE', $id)->first();

            if($empresa == null)
                $empresa = Empresa::where('URL3', 'LIKE', $id)->first();

            
            if($empresa != null)
            {
                return "no";
            }
            else
            {
                $id = str_replace("www.", "", $id);

                $pagina="http://www.".$id;

                if (@fopen($pagina,'r'))
                    return "no";
                else
                    return "si";
            }
        }
    }

    public function comprobar_url_sin_id($plan)
    {
        return "no";
    }

    private function crear_empresa($estado, $pago, $mp_id = null)
    {
        $business           = session('empresa');
        $usuario            = session('usuario');

        $empresa            = new Empresa();
        $empresa->nombre    = $business['nombre'];
        $empresa->carpeta   = "";
        $empresa->URL       = $business['url'];
        $empresa->URL1      = "www.".$business['url'];
        $empresa->plan      = $business['plan'];
        $empresa->estado    = $estado;
        $empresa->pago      = $pago;
        $empresa->expira    = $business['expira'];
        $empresa->mp_id     = $mp_id;
        $empresa->save();

        $user               = new User();
        $user->nombre       = $usuario['nombre'];
        $user->email        = $usuario['email'];
        $user->password     = $usuario['password'];
        $user->tipo         = "admin";
        $user->empresa_id   = $empresa->id;
        $user->save();

        Auth::login($user);
        
        instalar_tema_default();

        $configuracion              = new Configuracion();
        $configuracion->empresa_id  = $empresa->id;
        $configuracion->email_admin = $usuario['email'];
        $configuracion->titulo      = $business['titulo'];
        $configuracion->descripcion = $business['descripcion'];
        $configuracion->save();


        //Mail a administrador
        $contenido = [
            "titulo" => "Registro de nueva empresa",
            "empresa" => $empresa, 
        ];

        email("email.nueva_empresa.aviso_administrador", "Registro de nueva empresa", $contenido, "admin@tutiendafacil.uy");
        
        //Mail de bienvenida

        $contenido = [
            "titulo"    => "Bienvenido/a",
            "nombre"    => $usuario['nombre'],
            "email"     => $usuario['email'] 
        ];

        email("email.nueva_empresa.bienvenido", "Bienvenido/a a nuestra familia", $contenido, $empresa->configuracion->email_admin);

        registro(
            "info",
            $user->id,
            $user->empresa_id,
            "Login",
            "Empresa",
            "Se creo empresa"
        );
    }

    private function comprobar_codigo($codigo, $plan)
    {
        if($codigo != null)
        {
            $codigo = Codigo::where('codigo', $codigo)->first();

            if(($codigo == null) or ($codigo->cantidad == 0))
            {
                return "error1";
            }else
            {
                if($codigo->tipo == $plan)
                {
                    if($codigo->email != null)
                    {
                        if($codigo->email != Auth::user()->email)
                        {
                            return "error2";
                        }
                    }

                    if($codigo->cantidad == 1)
                    {
                        $codigo->delete();
                    }else
                    {
                        $codigo->cantidad -= 1;
                        $codigo->save();
                    }

                    return "total";

                }elseif($codigo->tipo == "descuento")
                {
                    if($codigo->cantidad == 1)
                    {
                        $codigo->delete();
                    }else
                    {
                        $codigo->cantidad -= 1;
                        $codigo->save();
                    }
                    
                    return $codigo->descuento;
                }else
                {
                    return "error3";
                }
            }
        }

        return "no";
    }

    public function pago_exitoso(Request $request)
    {
        if(Session()->has('empresa'))
        {
            $this->crear_empresa('creando', 'aprobado', $request->payment_id);
            return view('auth.planes.pago_exitoso');
        }

        return redirect('/');
    }

    public function pago_fallido(Request $request)
    {
        error("Error al realizar el pago, intentelo nuevamente");
        return back();
    }

    public function pago_pendiente(Request $request)
    {
        $this->crear_empresa('creando', 'pendiente', $request->payment_id);
        return view('auth.planes.pago_pendiente');
    }

    public function ver_expiro()
    {
        if((Auth::user()->empresa->pago == "prueba"))
        {
            $monto = opcion('plan1');
            $descripcion = "Plan básico - TuTiendaFacil.uy";
        }
        else
        {
            if(Auth::user()->empresa->plan == "plan1")
            {
                $monto = opcion('plan1');
                $descripcion = "Plan básico - TuTiendaFacil.uy";
            }
            elseif(Auth::user()->empresa->plan == "plan2")
            {
                $monto = opcion('plan2');
                $descripcion = "Plan avanzado - TuTiendaFacil.uy";
            }
            elseif(Auth::user()->empresa->plan == "plan3")
            {
                $monto = opcion('plan3');
                $descripcion = "Plan profesional - TuTiendaFacil.uy";
            }
        }

        MercadoPago\SDK::setAccessToken(env('MP_ACCESS_TOKEN'));

        $preference = new MercadoPago\Preference();

        $item                           = new MercadoPago\Item();
        $item->title                    = $descripcion;
        $item->quantity                 = 1;
        $item->currency_id              = "UYU";
        $item->unit_price               = $monto;
        $preference->items              = array($item);
        $preference->back_urls          = array(
                                            "success" => url('pago/expiro/exitoso'),
                                            "failure" => url('pago/expiro/fallido'),
                                            "pending" => url('pago/expiro/pendiente')
                                        );
        $preference->auto_return        = "approved"; 
        $preference->external_reference = Auth::user()->empresa->id;
        $preference->save();

        return view('auth.expiro.pago', compact('descripcion', 'monto', 'preference'));
    }

    public function expiro_exitoso(Request $request)
    {
        $empresa            = Auth::user()->empresa;
        $empresa->pago      = "aprobado";
        $empresa->expira    = Carbon::now()->addYear();
        $empresa->mp_id     = $request->payment_id;
        $empresa->save();

        registro(
            "info",
            usuario(),
            usuario('empresa'),
            "Expiro",
            "Aprobado",
            "Se aprobo el pago"
        );

        return view('auth.expiro.exitoso');
    }

    public function expiro_pendiente(Request $request)
    {
        $empresa            = Auth::user()->empresa;
        $empresa->pago      = "pendiente";
        $empresa->expira    = Carbon::now()->addYear();
        $empresa->mp_id     = $request->payment_id;
        $empresa->save();
        
        registro(
            "info",
            usuario(),
            usuario('empresa'),
            "Expiro",
            "Pendiente",
            "El pago esta pendiente"
        );

        return view('auth.expiro.pendiente');
    }

    public function expiro_fallido()
    {
        $empresa            = Auth::user()->empresa;
        $empresa->pago      = "rechazado";
        $empresa->save();

        registro(
            "info",
            usuario(),
            usuario('empresa'),
            "Expiro",
            "Rechazado",
            "El pago fue rechazado"
        );

        error("Error al realizar el pago, intentelo nuevamente");
        return back();
    }

    public function pago_online()
    {
        if(!Auth::check())
            return redirect('/');

        if(Auth::user()->empresa->estado != "pendiente")
            return redirect('/admin');

        $empresa = Auth::user()->empresa;

        if(Auth::user()->empresa->plan == "plan1")
        {
            $descripcion = "Plan básico - TuTiendaFacil.uy";
        }
        elseif(Auth::user()->empresa->plan == "plan2")
        {
            $descripcion = "Plan avanzado - TuTiendaFacil.uy";
        }
        elseif(Auth::user()->empresa->plan == "plan3")
        {
            $descripcion = "Plan profesional - TuTiendaFacil.uy";
        }

        MercadoPago\SDK::setAccessToken(env('MP_ACCESS_TOKEN'));

        $preference = new MercadoPago\Preference();

        $item                           = new MercadoPago\Item();
        $item->title                    = $descripcion;
        $item->quantity                 = 1;
        $item->currency_id              = "UYU";
        $item->unit_price               = $empresa->monto;

        $preference->items              = array($item);
        $preference->back_urls          = array(
                                            "success" => url('pago/expiro/exitoso'),
                                            "failure" => url('pago/expiro/fallido'),
                                            "pending" => url('pago/expiro/pendiente')
                                        );
        $preference->auto_return        = "approved"; 
        $preference->external_reference = Auth::user()->empresa->id;
        $preference->save();

        return view('auth.planes.pago_online', compact('empresa', 'preference'));
    }
}
