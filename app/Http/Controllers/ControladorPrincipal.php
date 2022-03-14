<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Arr;
use App\Models\Configuracion;
use App\Models\Newsletter;
use App\Models\Categoria;
use App\Models\Producto;
use App\Models\Empresa;
use App\Models\Mensaje;
use App\Models\Pagina;
use App\Models\Visita;
use App\Models\Venta;
use App\Models\Stock;
use App\Models\Error;
use App\Models\User;
use Carbon\Carbon;
use MercadoPago;
use Storage;
use Session;
use Auth;
use File;
use Hash;


class ControladorPrincipal extends Controller
{

    private $empresa;
    private $carpeta;

    public function __construct()
    {
        $this->empresa = empresa();
        
        if($this->empresa != null)
            $this->carpeta = 'empresas.'.$this->empresa->id.".".$this->empresa->carpeta.".";
    }

    public function dashboard()
    {
    	if(Auth::user()->tipo == "root")
    		return view('root.index');

        return view('admin.index');
    }

    public function index()
    {
        if($this->comprobar() != null)
            return $this->comprobar();

        if(view()->exists("empresas.".$this->empresa->id.".".$this->empresa->carpeta.".index"))
            return view("empresas.".$this->empresa->id.".".$this->empresa->carpeta.".index");

        return $this->error404();
    }

    public function categoria($id, Request $request)
    {
        if($this->comprobar() != null)
            return $this->comprobar();
        
        if(is_numeric($id))
            $categoria = Categoria::find($id);
        else
            $categoria   = $this->empresa->categorias->where('url', $id)->first();
        
        if(($categoria != null) and ($categoria->empresa_id == $this->empresa->id))
        {
            switch ($request->orden) {
                case 'desc':
                    $productos = $categoria->productos->where('estado','activo')->sortByDesc('nombre');
                    break;
                
                case 'asc':
                    $productos = $categoria->productos->where('estado','activo')->sortBy('nombre');
                    break;

                case 'may':
                    $productos = $categoria->productos->where('estado','activo')->sortByDesc('precio');
                    break;

                case 'men':
                    $productos = $categoria->productos->where('estado','activo')->sortBy('precio');
                    break;
                
                default:
                    $productos = $categoria->productos->where('estado','activo')->sortByDesc('nombre');
                    break;
            }    
            
            if(view()->exists($this->carpeta."categoria-".$id))
                return view($this->carpeta."categoria-".$id, compact('categoria', 'productos'));
            
            if(view()->exists($this->carpeta."categoria"))
                return view($this->carpeta."categoria", compact('categoria', 'productos'));
        }

        return $this->error404();
    }

    public function productos(Request $request)
    {   
        if($this->comprobar() != null)
            return $this->comprobar();

        if($request->busqueda != null)
        {
            $productos_inicio = Producto::where('empresa_id', $this->empresa->id)
                                ->where('nombre', 'LIKE', '%'.$request->busqueda.'%')
                                ->where('estado', 'activo')
                                ->get();
            
        }
        else
        {
            $productos_inicio = $this->empresa->productos->where('estado','activo');
        }

        switch ($request->orden) 
        {
            case 'asc':
                $productos = $productos_inicio->sortBy('nombre');
                break;

            case 'desc':
                $productos = $productos_inicio->sortByDesc('nombre');
                break;

            case 'may':
                $productos_precio = new collection();
                $productos = new collection();

                foreach($productos_inicio as $producto)
                {
                    $precio = 0;
                    
                    if($producto->precio_promocion != null)
                        $precio = $producto->precio_promocion;
                    else
                        $precio = $producto->precio;

                    $productos_precio->add(['precio' => $precio, 'producto' => $producto]);
                }

                foreach($productos_precio->sortByDesc('precio') as $producto_precio)
                    $productos->add($producto_precio['producto']);

                break;

            case 'men':
                
                $productos_precio = new collection();
                $productos = new collection();

                foreach($productos_inicio as $producto)
                {
                    $precio = 0;
                    
                    if($producto->precio_promocion != null)
                        $precio = $producto->precio_promocion;
                    else
                        $precio = $producto->precio;

                    $productos_precio->add(['precio' => $precio, 'producto' => $producto]);
                }

                foreach($productos_precio->sortBy('precio') as $producto_precio)
                    $productos->add($producto_precio['producto']);

                break;
            
            default:
                $productos = $productos_inicio->sortBy('nombre');
                break;
        }    

        if(view()->exists($this->carpeta."productos"))
            return view($this->carpeta."productos", compact('productos'));

        $this->error404();   
    }

    public function producto($id)
    {
        if($this->comprobar() != null)
            return $this->comprobar();

        if(is_numeric($id))
            $producto = Producto::find($id);
        else
            $producto   = $this->empresa->productos->where('url', $id)->first();
        
        if(($producto != null) and ($producto->estado == "activo") and (view()->exists($this->carpeta."producto")))
            return view($this->carpeta."producto", compact('producto'));   

        return $this->error404();;
    }

    public function carrito()
    {
        if($this->comprobar() != null)
            return $this->comprobar();

        $productos  = Session::get('carrito');

        if(view()->exists($this->carpeta."carrito"))
            return view($this->carpeta."carrito", compact('productos'));   
        
        return $this->error404();
    }

    public function comprar_ahora($id)
    {
        $producto = Producto::find($id);

        do
        {
            $codigo = codigo_aleatorio_numerico(10);
            $old    = Venta::where('codigo', $codigo)->first();

        }while( $old != null);

        $venta              = new Venta();
        $venta->empresa_id  = $this->empresa->id;
        $venta->codigo      = $codigo;
        $venta->codigo_num  = $codigo;
        $venta->estado      = "comenzado";

        $precio = 0;
        if($producto->precio_promocion == null)
            $precio = $producto->precio;
        else
            $precio = $producto->precio_promocion;

        $venta->precio = $precio;
        $venta->save();

        $venta->productos()->attach($producto->id, [
                    'cantidad' => '1', 
                    'precio' => $precio,
                    'empresa_id' => $this->empresa->id, 
                    'created_at' => Carbon::now()
                ]);
        
        return redirect(env('APP_URL')."/checkout/".$venta->codigo);
    }

    public function agregar_carrito(Request $request)
    {
        $producto = Producto::find($request->producto);

        if($producto != null)
        {
            $variante = null;

            if($request->variante != null)
                $variante = Stock::find($request->variante);

            for ($i=0; $i < $request->cantidad; $i++)
            {
                $coleccion = collect([
                    "id" => codigo_aleatorio(10),
                    "producto" => $producto, 
                    "variante" => $variante
                ]);

                Session::push('carrito', $coleccion);   
            }
        }

        return back();
    }

    public function eliminar_carrito($id)
    {
        $productos = Session::get('carrito');

        if($productos != null)
        {
            Session::flush('carrito');

            foreach ($productos as $producto)
            {
                if($producto['id'] != $id)
                {
                    $coleccion = collect([
                            "id" => $producto['id'], 
                            "producto" => $producto['producto'], 
                            "variante" => $producto['variante']
                        ]);

                    Session::push('carrito', $coleccion);
                }
            }
        }
        return back();
    }

    public function vaciar_carrito()
    {
        Session::flush('carrito');

        return back();
    }

    public function comprar()
    {
        if(Session::get('carrito') != null)
        {
            do
            {
                $codigo = codigo_aleatorio_numerico(10);
                $old    = Venta::where('codigo', $codigo)->first();

            }while( $old != null);

            $venta              = new Venta();
            $venta->empresa_id  = $this->empresa->id;
            $venta->codigo      = $codigo;
            $venta->codigo_num  = $codigo;
            $venta->estado      = "comenzado";
            $venta->save();

            $precio_total = 0;

            foreach (Session::get('carrito') as $producto) 
            {
                $precio = 0;
                
                if($producto['producto']->precio_promocion == null)
                    $precio = $producto['producto']->precio;
                else
                    $precio = $producto['producto']->precio_promocion;

                if($producto['variante'] != null)
                    $variante = $producto['variante']->id;
                else
                    $variante = null;

                $venta->productos()->attach(
                        $producto['producto']->id,
                            [
                                'cantidad' => "1", 
                                'precio' => $precio,
                                'variante_id' => $variante,
                                'empresa_id' => $this->empresa->id,
                                'created_at' => Carbon::now()
                            ]
                        );

                $precio_total += $precio;
            }
            
            $venta->precio = $precio_total;
            $venta->save();
            
            Session::flush('carrito');
            return redirect(env('APP_URL')."/checkout/".$venta->codigo);
        }
        
        return back();
    }

    public function pagina($id)
    {
        if($this->comprobar() != null)
            return $this->comprobar();

        $pagina     = $this->empresa->paginas->where('url', $id)->first();

        if($pagina != null)
        {
            if(view()->exists($this->carpeta."pagina-".$id))
                return view($this->carpeta."pagina-".$id);
            
            if(view()->exists($this->carpeta."pagina"))
                return view($this->carpeta."pagina", compact('pagina'));
        }

        return $this->error404();
    }

    public function contacto(Request $request)
    {
        $contenido = [
            "titulo"    => "Contacto desde TuTiendaFacil.uy",
            "nombre"    => $request->nombre,
            "email"     => $request->email,
            "mensaje"   => $request->mensaje,
        ];

        email('email.mensaje.nuevo', "Contacto desde TuTiendaFacil.uy", $contenido, "admin@tutiendafacil.uy");

        exito('El mensaje se envio correctamente, nos comunicaremos a la brevedad.');
        return redirect('/#contact');
    }

    public function contacto_empresa(Request $request)
    {
        $mensaje                = new Mensaje();
        $mensaje->nombre        = $request->nombre;
        $mensaje->email         = $request->email;
        $mensaje->contenido     = $request->contenido;
        $mensaje->estado        = "nuevo";
        $mensaje->empresa_id    = $this->empresa->id;
        $mensaje->save();

        $contenido = [
            "titulo"    => "Contacto desde ".$this->empresa->URL,
            "nombre"    => $request->nombre,
            "email"     => $request->email,
            "mensaje"   => $request->contenido,
        ];

        email('email.contacto', "Contacto desde la web de ".$this->empresa->nombre, $contenido, $this->empresa->configuracion->email_admin);

        exito('El mensaje se envio correctamente, nos comunicaremos a la brevedad.');
        return back();
    }

    public function visita(Request $request)
    {
        $old = Visita::where('ip', $request->ip)
                        ->where('url', $request->url)
                        ->orderBy('created_at', 'desc')
                        ->first();

        if(($old == null) or (Carbon::now()->diffInMinutes($old->created_at) >= 30))
        {
            if($request->url != "/carrito")
            {
                $visita                 = new Visita();
                $visita->empresa_id     = $this->empresa->id;
                $visita->ip             = $request->ip;
                $visita->ciudad         = $request->ciudad;
                $visita->pais           = $request->pais;
                $visita->url            = $request->url;
                $visita->dispositivo    = $request->dispositivo;
                $visita->fecha          = date("Y-m-d");
                $visita->save();

                return true;
            }
        }

        return false;
    }

    public function newsletter(Request $request)
    {
        $old = $this->empresa->newsletters->where('email', $request->email)->first();
        
        if($old == null)
        {
            $suscriptor             = new Newsletter();
            $suscriptor->email      = $request->email;
            $suscriptor->empresa_id = $this->empresa->id;
            $suscriptor->save();

            exito("Su email fue guardado correctamente");

        }else
        {
            error("Su email ya esta registrado en la newsletter");
        }

        return back();
    }

    public function url($id)
    {
        if($this->comprobar() != null)
            return $this->comprobar();

        $producto   = $this->empresa->productos->where('url', $id)->first();

        if(($producto != null) and ($producto->estado == "activo"))
        {
            if(view()->exists($this->carpeta."producto"))
                return view($this->carpeta."producto", compact('producto'));   
        }
            
        return $this->error404();
    }

    public function eticket($id)
    {
        $venta = Venta::where('codigo', $id)->first();

        if($venta != null)
            return view('compra.resumen', compact('venta'));
        
        return abort(404);
    }

    public function generar_codigo()
    {
        $codigo = codigo_aleatorio_numerico(5);
        $hora   = now();

        $empresa = Auth::user()->empresa;

        $empresa->control_codigo    = $codigo;
        $empresa->control_hora      = $hora;
        $empresa->control_usuario   = usuario();
        $empresa->save();

        registro(
            "control",
            usuario(),
            usuario('empresa'),
            "Control",
            "Conceder control",
            "El usuario concedio control al ROOT"
        );

        return $codigo;
    }

    private function comprobar()
    {
        if($this->empresa == null)
            return view('landing.index');

        if(Carbon::now()->diffInDays($this->empresa->expira, false) <= 0)
            return view('errors.expiro');

        if($this->empresa->configuracion->construccion == "on")
            return view('errors.construccion');
    }

    private function error404()
    {
        if(view()->exists($this->carpeta."404"))
            return view($this->carpeta."404");
        
        return abort(404);
    }

}
