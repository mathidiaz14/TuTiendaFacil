<?php

/*****************************************************
 Archivo con funciones que se reutilizan varias veces 
******************************************************/


//Funciones del sistema

if (! function_exists('registro')) 
{
	function registro($estado, $usuario, $empresa, $objeto, $accion, $mensaje)
	{
		$log 				= new \App\Models\Log();
		$log->estado 		= $estado;
		$log->usuario_id 	= $usuario;
		$log->empresa_id 	= $empresa;
		$log->objeto 		= $objeto;
		$log->accion 		= $accion;
		$log->mensaje 		= $mensaje;
		$log->save();

		return true;
	}
}

if (! function_exists('usuario')) 
{
	function usuario($dato = "id")
	{
		if(Auth::check())
		{
			switch ($dato) {
				case 'id':
					return Auth::user()->id;
					break;
				
				case 'nombre':
					return Auth::user()->nombre;
					break;
				
				case 'email':
					return Auth::user()->email;
					break;
				
				case 'ci':
					return Auth::user()->ci;
					break;
				
				case 'empresa':
					return Auth::user()->empresa_id;
					break;
				
				case 'tipo': 
					return Auth::user()->tipo; 
					break;
			}
		}
	}
}

if (! function_exists('control_empresa')) 
{
	function control_empresa($id)
	{
		if($id == Auth::user()->empresa_id)
			return true;

		return false;
	}
}

if (! function_exists('exito')) 
{
	function exito($mensaje)
	{
		session(['exito' => $mensaje]);
	}
}

if (! function_exists('error')) 
{
	function error($mensaje)
	{
		session(['error' => $mensaje]);
	}
}


if (! function_exists('codigo_unico')) 
{
	function codigo_unico($id, $digitos = 6)
	{
		return str_pad($id, $digitos, "0", STR_PAD_LEFT);
	}
}

if (! function_exists('codigo_aleatorio')) 
{
	function codigo_aleatorio($cantidad = 10)
	{
		return substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, $cantidad); 
	}
}

if (! function_exists('codigo_aleatorio_numerico')) 
{
	function codigo_aleatorio_numerico($cantidad = 10)
	{
		return substr(str_shuffle("0123456789"), 0, $cantidad); 
	}
}

if(! function_exists('copiar'))
{
	function copiar( $source, $target ) {
	    if ( is_dir( $source ) ) {
	        @mkdir( $target );
	        $d = dir( $source );
	        while ( FALSE !== ( $entry = $d->read() ) ) {
	            if ( $entry == '.' || $entry == '..' ) {
	                continue;
	            }
	            $Entry = $source . '/' . $entry; 
	            if ( is_dir( $Entry ) ) {
	                copiar( $Entry, $target . '/' . $entry );
	                continue;
	            }
	            copy( $Entry, $target . '/' . $entry );
	        }
	 
	        $d->close();
	    }else {
	        copy( $source, $target );
	    }
	}
}

if(! function_exists('eliminar_carpeta'))
{
	function eliminar_carpeta($carpeta)
	{
		foreach(glob($carpeta . "/*") as $archivos_carpeta)
		{             
	        if (is_dir($archivos_carpeta))
	          	eliminar_carpeta($archivos_carpeta);
	        else
	        	unlink($archivos_carpeta);
	    }
	     
	    rmdir($carpeta);
	}
}

if(! function_exists('opcion'))
{
	function opcion($key) 
	{
		$opcion = App\Models\Opcion::first();
		
		if($opcion[$key] != null)
			return $opcion[$key];

		return null;   
	}
}

if(! function_exists('configuracion'))
{
	function configuracion()
	{
		if(Auth::check())
			return Auth::user()->empresa->configuracion;
	}
}

if(! function_exists('crear_notificacion'))
{
	function crear_notificacion($titulo, $contenido, $url, $empresa)
	{
		$notificacion 				= new \App\Models\Notificacion();
		$notificacion->titulo 		= $titulo;
		$notificacion->contenido 	= $contenido;
		$notificacion->estado		= "nuevo";
		$notificacion->url 			= $url;
		$notificacion->empresa_id 	= $empresa;
		$notificacion->save();

		return true;
	}
}

if(! function_exists('email'))
{
	function email($plantilla, $asunto, $contenido, $destinatario)
	{
		\Mail::to($destinatario)->send(
								new \App\Mail\envioEmail($contenido, $plantilla, $asunto)
							);
		return true;
	}
}


if(! function_exists('myasset'))
{
	function myasset($path)
    {
        return asset("empresas/".empresa()->id."/".empresa()->carpeta."/".$path);
    }
}

if(! function_exists('instalar_tema'))
{
	function instalar_tema($id)
    {
        $tema       = \App\Models\Tema::find($id);
        $empresa    = \Auth::user()->empresa;
        $nombre 	= codigo_aleatorio(10);
        $ruta 		= 'views/empresas/'.Auth::user()->empresa->id."/".$nombre;
        
        $empresa->temas()->attach($tema, ['estado' => 'instalado', 'carpeta' => $nombre]);

        mkdir(resource_path($ruta, 0777));

        copiar(
            resource_path('views/temas/'.$tema->carpeta), 
            resource_path($ruta)
        );
    }
}

if (! function_exists('instalar_tema_default'))
{
	function instalar_tema_default()
	{
		$empresa = \Auth::user()->empresa;

		$tema       = \App\Models\Tema::find(1);
        $nombre 	= codigo_aleatorio(10);

        $empresa->temas()->attach($tema, ['estado' => 'instalado', 'carpeta' => $nombre]);
        $empresa->carpeta = $nombre;
        $empresa->save();
        
        mkdir(resource_path('views/empresas/'.$empresa->id, 0777));
        mkdir(resource_path('views/empresas/'.$empresa->id."/".$nombre, 0777));

        copiar(
            resource_path('views/temas/'.$tema->carpeta), 
            resource_path('views/empresas/'.$empresa->id."/".$nombre)
        );

        $contenido = simplexml_load_file(
                        resource_path('views/empresas/'.$empresa->id."/".$nombre."/install.xml")
                    );

        foreach($contenido as $elemento)
        {
            \App\Models\Landing::create([
                'titulo'        => $elemento->titulo,
                'llave'         => $elemento->llave,
                'valor'         => $elemento->valor,
                'tipo'          => $elemento->tipo,
                'empresa_id'    => $empresa->id
            ]);
        }
	}
}

//Funciones de Temas

if(! function_exists('empresa'))
{
	function empresa()
	{
		$string = str_replace("http://", "", url('/'));
		$string = str_replace("https://", "", $string);

		if(Auth::check())
			return Auth::user()->empresa;

		$empresa = App\Models\Empresa::where('URL', 'LIKE', $string)->first();

		if($empresa == null)
			$empresa = App\Models\Empresa::where('URL1', 'LIKE', $string)->first();

		if($empresa == null)
			$empresa = App\Models\Empresa::where('URL2', 'LIKE', $string)->first();

		if($empresa == null)
			$empresa = App\Models\Empresa::where('URL3', 'LIKE', $string)->first();
		
		return $empresa;
	}
}

if(! function_exists('i'))
{
	function i($clave)
	{
		$info = empresa()->configuracion[$clave];

		if($info != null)
			return $info;

		return "";
	}
}


if(! function_exists('destacados'))
{
	function destacados($cantidad = 4)
	{
		return empresa()->productos->where('estado', 'activo')->where('destacado', 'on')->take($cantidad);
	}
}

if(! function_exists('precio_formato'))
{
	function precio_formato($precio)
	{
		return number_format($precio, 0, ',', '.');
	}
}

if(! function_exists('comprar'))
{
	function comprar()
	{
		return url('comprar');
	}
}

if(! function_exists('comprar_ahora'))
{
	function comprar_ahora($id)
	{
		return url('comprar_ahora', $id);
	}
}

if(! function_exists('agregar_carrito'))
{
	function agregar_carrito($id)
	{
		return url('agregar_carrito', $id);
	}
}

if(! function_exists('cantidad_productos_carrito'))
{
	function cantidad_productos_carrito()
	{
		$i = 0;
		
		if(Session::has('carrito'))
		{
			foreach (Session::get('carrito') as $producto)
				$i++;
		}

		return $i;    
	}
}

if(! function_exists('eliminar_producto_carrito'))
{
	function eliminar_producto_carrito($id)
	{
		return url('eliminar_carrito', $id);
	}
}

if(! function_exists('logo_url'))
{
	function logo_url()
	{
		if(empresa()->configuracion->logo != null)
			return asset(empresa()->configuracion->logo);
		else
			return asset("img/logo_default.jpg");
	}
}

if(! function_exists('login_url'))
{
	function login_url()
	{
		return env('APP_URL')."/login";
	}
}

if(! function_exists('landing'))
{
	function landing($key) 
	{
		$landing = App\Models\Landing::where('empresa_id', empresa()->id)
										->where('llave', $key)
										->first();
		if($landing != null)
			return $landing->valor;

		return null;   
	}
}

//Funciones categorias

if(! function_exists('categoria'))
{
	function categoria($id)
	{
		$categoria = \App\Models\Categoria::find($id);

		if($categoria != null)
			return $categoria;

		return "";
	}
}

if(! function_exists('categorias'))
{
	function categorias($cantidad = 100)
	{
		return empresa()->categorias->take($cantidad);
	}
}

if(! function_exists('categoria_url_imagen'))
{
	function categoria_url_imagen($id)
	{
		$categoria = App\Models\Categoria::find($id);

		if($categoria != null)
		{
            if($categoria->imagen != null)
                return asset($categoria->imagen);
		}

        return asset("img/producto_default.jpg");
	}
}

if(! function_exists('categoria_url'))
{
	function categoria_url($id)
	{
		$categoria = App\Models\Categoria::find($id);

		if(($categoria != null) and ($categoria->empresa_id == empresa()->id))
			return url('categoria', $categoria->url);

		return false;
	}
}

//Funciones productos


if(! function_exists('productos'))
{
	function productos($cantidad = 100)
	{
		return empresa()->productos->where('estado', 'activo')->sortByDesc('created_at')->take($cantidad);
	}
}

if(! function_exists('producto_url_imagen'))
{
	function producto_url_imagen($id)
	{
		$producto = App\Models\Producto::find($id);

		if($producto != null)
		{
			if($producto->multimedia->where('tipo', 'principal')->count() == 1)
			{
	            return asset($producto->multimedia->where('tipo', 'principal')->first()->url);
			}
	        else
	        {
	            if($producto->multimedia->count() >= 1)
	                return asset($producto->multimedia->first()->url);
	        }
		}

        return asset("img/producto_default.jpg");
	}
}

if(! function_exists('producto_stock_bool'))
{
	function producto_stock_bool($id)
	{
		$producto = App\Models\Producto::find($id);

		if($producto != null)
		{
			if((($producto->cantidad != null) and ($producto->cantidad > 0)) or ($producto->variantes->count('cantidad') > 0))
                return true;
            elseif((($producto->cantidad != null) and ($producto->cantidad == 0)) or (($producto->variantes->first() != null) and ($producto->variantes->count('cantidad') == 0)))
                return false;
		}

		return false;
	}
}

if(! function_exists('producto_stock_cantidad'))
{
	function producto_stock_cantidad($id)
	{
		$producto = App\Models\Producto::find($id);

		if($producto != null)
		{
			if($producto->variantes->sum('cantidad') > 0)
                return $producto->variantes->sum('cantidad');
			elseif($producto->cantidad != null)
				return $producto->cantidad;
		}

		return null;
	}
}

if(! function_exists('producto_nuevo'))
{
	function producto_nuevo($id)
	{
		$producto = App\Models\Producto::find($id);

		if($producto != null)
		{
			if($producto->nuevo == 'on')
				return true;
			else
                return false;
		}

		return false;
	}
}

if(! function_exists('producto_url'))
{
	function producto_url($id)
	{
		$producto = App\Models\Producto::find($id);

		if($producto != null)
			return url('producto', $producto->url);

		return false;
	}
}

if(! function_exists('producto_precio'))
{
	function producto_precio($id)
	{
		$producto = App\Models\Producto::find($id);

		if($producto != null)
		{
			if($producto->precio_promocion == null)
				return $producto->precio;
			else
				return $producto->precio_promocion;
		}
		
		return false;
	}
}

if(! function_exists('productos_precio_total'))
{
	function productos_precio_total($productos)
	{
		$suma = 0;
		
		foreach($productos as $producto)
		{
			if($producto['producto']->precio_promocion == null)
				$suma += $producto['producto']->precio;
			else
				$suma += $producto['producto']->precio_promocion;
		}

		return $suma;
	}
}

if(! function_exists('producto_variante'))
{
	function producto_variante($id)
	{
		$variante = App\Models\Stock::find($id);
		
		if($variante != null)
			return $variante->nombre;
		
		return null;
	}
}

if(! function_exists('producto_categoria'))
{
	function producto_categoria($id)
	{
		$producto = App\Models\Producto::find($id);

		if($producto->categoria_id != null)
			return $producto->categoria->titulo;

		return null;
	}
}

if(! function_exists('suma_productos'))
{
	function suma_productos($productos)
	{
		$suma = 0;
		
		foreach($productos as $producto)
		{
			if($producto->precio_promocion == null)
				$suma += $producto->precio;
			else
				$suma += $producto->precio_promocion;
		}

		return $suma;
	}
}

if(! function_exists('precio_producto'))
{
	function precio_producto($id)
	{
		$producto = App\Models\Producto::find($id);

		if($producto != null)
		{
			if($producto->precio_promocion == null)
				return $producto->precio;
			else
				return $producto->precio_promocion;
		}
		
		return false;
	}
}

//Funciones de pagina

if(! function_exists('paginas'))
{
	function paginas($cantidad = 10)
	{	
		return empresa()->paginas->take($cantidad);
	}
}

if(! function_exists('pagina_url'))
{
	function pagina_url($id)
	{
		$pagina = App\Models\Pagina::find($id);

		if(($pagina != null) and ($pagina->empresa_id == empresa()->id))
			return url('pagina', $pagina->url);

		return false;
	}
}


//Funciones blog

if(! function_exists('plugin_blog_instalado'))
{
	function plugin_blog_instalado()
	{
		$plugin = empresa()->plugins->where('carpeta', 'blog')->first();

		if(($plugin != null) and ($plugin->pivot->estado == "activo"))
			return true;

		return false;
	}
}

if(! function_exists('blog_extracto'))
{
	function blog_extracto($entrada)
	{
		if($entrada->extracto != null)
			return substr($entrada->extracto, 0, 200);

		return substr($entrada->contenido, 0, 200);
	}
}

if(! function_exists('blog_categoria_titulo'))
{
	function blog_categoria_titulo($entrada)
	{
		if($entrada->categoria_id != null)
			return $entrada->categoria->titulo;

		return null;
	}
}

if(! function_exists('blog_entrada_url'))
{
	function blog_entrada_url($entrada)
	{
		return url('blog', $entrada->url);
	}
}

if(! function_exists('blog_categoria_url'))
{
	function blog_categoria_url($categoria)
	{
		if($categoria != null)
			return url('blog/categoria', $categoria->url);
		
		return "false";
	}
}

if(! function_exists('blog_categorias'))
{
	function blog_categorias()
	{

		return empresa()->blogCategorias;
	}
}

if(! function_exists('blog_fecha_entrada'))
{
	function blog_fecha_entrada($entrada, $formato = "d/m/y")
	{
		$fecha = $entrada->created_at->format($formato);

		$fecha = str_replace("Jan", "Ene", $fecha);
		$fecha = str_replace("Feb", "Feb", $fecha);
		$fecha = str_replace("Apr", "Abr", $fecha);
		$fecha = str_replace("Aug", "Ago", $fecha);
		$fecha = str_replace("Sep", "Set", $fecha);
		$fecha = str_replace("Dec", "Dic", $fecha);
		
		return $fecha;
	}
}

if(! function_exists('blog_ultimas_entradas'))
{
	function blog_ultimas_entradas($cantidad = 5)
	{
		return empresa()->blogEntradas->take($cantidad);
	}
}

if(! function_exists('blog_ultimas_entradas'))
{
	function blog_ultimas_entradas($cantidad = 5)
	{
		return empresa()->blogEntradas->take($cantidad);
	}
}

if(! function_exists('blog_entrada_autor'))
{
	function blog_entrada_autor($entrada)
	{
		return $entrada->usuario->nombre;
	}
}

if(! function_exists('blog_entrada_autor_url'))
{
	function blog_entrada_autor_url($entrada)
	{
		return url('blog/autor', $entrada->usuario->id);
	}
}

if(! function_exists('blog_comentarios'))
{
	function blog_comentarios($entrada)
	{
		if($entrada->comentario_activo)
			return $entrada->comentarios->where('estado', 'aprobado')->where('parent_id', null);

		return false;
	}
}

if(! function_exists('blog_comentarios_activos'))
{
	function blog_comentarios_activos($entrada)
	{
		if($entrada->comentario_activo)
			return true;

		return false;
	}
}

if(! function_exists('wpp_url'))
{
	function wpp_url($id)
	{
		$empresa = empresa();
	    $plugin  = $empresa->plugins->where('carpeta', 'VentaPorWpp')->first();

		if($plugin->pivot->estado == 'activo')
		{
			$producto 	= App\Models\Producto::find($id);
			$nombre 	= str_replace(" ", "%20", $producto->nombre);

			return "https://wa.me/".empresa()->configuracion->telefono."?text=Me%20interesa%20el%20producto%20\"".$nombre."\".%20Me%20darias%20mas%20detalles?";
		}

		return false;
	}
}

if(! function_exists('wpp_estado'))
{
	function wpp_estado()
	{
		$empresa = empresa();
	    $plugin  = $empresa->plugins->where('carpeta', 'VentaPorWpp')->first();

		if(($plugin != null) and ($plugin->pivot->estado == 'activo'))
		{
			if(empresa()->ventaPorWpp != null)
				return true;
		}

		return false;
	}
}

// Funciones que llaman a views

if(! function_exists('ttf_carpeta'))
{
	function ttf_carpeta()
	{
		return "empresas.".empresa()->id.".".empresa()->carpeta;
	}
}

if(! function_exists('ttf_footer'))
{
	function ttf_footer()
	{
		return view('ayuda.footer');
	}
}

if(! function_exists('ttf_busqueda'))
{
	function ttf_busqueda() 
	{
		return view('ayuda.busqueda');  
	}
}

if(! function_exists('ttf_extends'))
{
	function ttf_extends($path)
    {
        return "empresas.".empresa()->id.".".empresa()->carpeta.".".$path;
    }
}

//Funcion de ayuda

if(! function_exists('random_style'))
{
	function random_style()
	{
		$estilo = collect([
			"style1",
			"style2",
			"style3",
			"style4",
			"style5",
			"style6",
		]);

		return $estilo[rand(0,5)];
	}
}

