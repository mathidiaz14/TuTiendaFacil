<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ControladorPrincipal;
use App\Http\Controllers\ControladorCategoria;
use App\Http\Controllers\ControladorProducto;
use App\Http\Controllers\ControladorCliente;
use App\Http\Controllers\ControladorVenta;
use App\Http\Controllers\ControladorProveedor;
use App\Http\Controllers\ControladorMultimedia;
use App\Http\Controllers\ControladorConfiguracion;
use App\Http\Controllers\ControladorUsuario;
use App\Http\Controllers\ControladorStock;
use App\Http\Controllers\ControladorLocal;
use App\Http\Controllers\ControladorPago;
use App\Http\Controllers\ControladorMercadoPago;
use App\Http\Controllers\ControladorPagina;
use App\Http\Controllers\ControladorNotificacion;
use App\Http\Controllers\ControladorRegistroYPlanes;
use App\Http\Controllers\ControladorLanding;
use App\Http\Controllers\ControladorMensaje;
use App\Http\Controllers\ControladorNewsletter;
use App\Http\Controllers\ControladorTema;
use App\Http\Controllers\ControladorPlugin;
use App\Http\Controllers\ControladorError;
use App\Http\Controllers\ControladorVisita;
use App\Http\Controllers\ControladorCupon;

use App\Http\Controllers\Root\RootControladorEmpresas;
use App\Http\Controllers\Root\RootControladorUsuarios;
use App\Http\Controllers\Root\RootControladorVentas;
use App\Http\Controllers\Root\RootControladorCodigos;
use App\Http\Controllers\Root\RootControladorOpciones;
use App\Http\Controllers\Root\RootControladorMensajesError;
use App\Http\Controllers\Root\RootControladorError;
use App\Http\Controllers\Root\RootControladorGit;
use App\Http\Controllers\Root\RootControladorAdministrar;
use App\Http\Controllers\Root\RootControladorAyudaCategoria;
use App\Http\Controllers\Root\RootControladorAyudaEntrada;
use App\Http\Controllers\Root\RootControladorLog;

use App\Http\Controllers\Plugins\Blog\BlogControladorEntrada;
use App\Http\Controllers\Plugins\Blog\BlogControladorComentario;
use App\Http\Controllers\Plugins\Blog\BlogControladorCategoria;
use App\Http\Controllers\Plugins\Blog\BlogControladorConfiguracion;
use App\Http\Controllers\Plugins\Blog\BlogControladorPrincipal;

use App\Http\Controllers\Plugins\VentaPorWpp\VentaPorWppControladorPrincipal;

use App\Http\Controllers\Ayuda\ControladorAyudaPrincipal;

/* Controladores de prueba*/

Route::get('ver_email', function()
{
	
    $contenido = [
        "pagina" => "moriarty.uy",
        "url" => url('checkout/pago', "123456"),
    ];
    

   return view('email.recordatorio_compra', compact('contenido'));
});

Route::get('/', 												[ControladorPrincipal::class ,'index']);


Route::get('recargar-csrf', function(){
    return csrf_token();
});

/* Controladores para registro de empresas y elección de planes*/

Route::post('login', 											[ControladorRegistroYPlanes::class ,'login']);
Route::get('registrar', 										[ControladorRegistroYPlanes::class ,'ver_registrarse']);
Route::get('registrarse', 										[ControladorRegistroYPlanes::class ,'ver_registrarse']);
Route::get('empezar', 										 	[ControladorRegistroYPlanes::class ,'ver_registrarse']);
Route::post('registrarse', 										[ControladorRegistroYPlanes::class ,'registrarse']);
Route::get('envio_contrasena',									[ControladorRegistroYPlanes::class ,'ver_reseteo_contrasena_envio']);
Route::post('envio_contrasena',									[ControladorRegistroYPlanes::class ,'reseteo_contrasena_envio']);
Route::get('resetear/contrasena/{id}',							[ControladorRegistroYPlanes::class ,'ver_reseteo_contrasena']);
Route::post('resetear/contrasena',								[ControladorRegistroYPlanes::class ,'reseteo_contrasena']);

Route::post('registrar/plan1', 									[ControladorRegistroYPlanes::class ,'plan1']);
Route::post('registrar/plan2', 									[ControladorRegistroYPlanes::class ,'plan2']);
Route::post('registrar/plan3', 									[ControladorRegistroYPlanes::class ,'plan3']);
Route::get('registrar/comprobar/{plan}/{ID}',					[ControladorRegistroYPlanes::class ,'comprobar_url']);
Route::get('registrar/comprobar/{plan}',						[ControladorRegistroYPlanes::class ,'comprobar_url_sin_id']);
Route::get('registrar/expiro',									[ControladorRegistroYPlanes::class ,'ver_expiro'])->middleware('auth');

Route::get('registrar/pago/online',                             [ControladorRegistroYPlanes::class ,'pago_online']);

Route::get('registrar/pago/exitoso',							[ControladorRegistroYPlanes::class ,'pago_exitoso']);
Route::get('registrar/pago/pendiente',							[ControladorRegistroYPlanes::class ,'pago_pendiente']);
Route::get('registrar/pago/fallido',							[ControladorRegistroYPlanes::class ,'pago_fallido']);

Route::get('pago/expiro/exitoso',								[ControladorRegistroYPlanes::class ,'expiro_exitoso']);
Route::get('pago/expiro/pendiente',								[ControladorRegistroYPlanes::class ,'expiro_pendiente']);
Route::get('pago/expiro/fallido',								[ControladorRegistroYPlanes::class ,'expiro_fallido']);

/* Controladores de administrador de cada empresa*/

Route::get('/admin', 											[ControladorPrincipal::class ,'dashboard'])->middleware('admin');
Route::resource('admin/proveedor', 								ControladorProveedor::class)->middleware('admin');
Route::resource('admin/usuario', 								ControladorUsuario::class)->middleware('admin');
Route::resource('admin/stock', 									ControladorStock::class)->middleware('admin');
Route::resource('admin/local', 									ControladorLocal::class)->middleware('admin');
Route::resource('admin/multimedia', 							ControladorMultimedia::class)->middleware('admin');
Route::resource('admin/visita',									ControladorVisita::class)->middleware('admin');
Route::resource('admin/usuario',								ControladorUsuario::class)->middleware('admin');
Route::resource('admin/newsletter', 							ControladorNewsletter::class)->middleware('admin');
Route::resource('admin/categoria', 								ControladorCategoria::class)->middleware('admin');
Route::resource('admin/producto', 								ControladorProducto::class)->middleware('admin');
Route::resource('admin/cliente', 								ControladorCliente::class)->middleware('admin');
Route::get('admin/categoria/borrar/imagen/{ID}',				[ControladorCategoria::class ,'borrar_imagen']);


Route::resource('admin/venta', 									ControladorVenta::class)->middleware('admin');
Route::get('admin/venta/entregar/{id}',							[ControladorVenta::class ,'entregar'])->middleware('admin');
Route::get('admin/venta/devolver/{id}',							[ControladorVenta::class ,'devolver'])->middleware('admin');
Route::get('admin/venta/cancelar/{id}',							[ControladorVenta::class ,'cancelar'])->middleware('admin');


Route::resource('admin/pagina',									ControladorPagina::class)->middleware('admin');
Route::get('admin/pagina/eliminar/imagen/{id}',					[ControladorPagina::class ,'eliminar_imagen'])->middleware('admin');
Route::get('admin/perfil',										[ControladorUsuario::class ,'ver_perfil'])->middleware('admin');
Route::post('admin/perfil',										[ControladorUsuario::class ,'perfil'])->middleware('admin');
Route::post('admin/principal/multimedia', 						[ControladorMultimedia::class ,'principal'])->middleware('admin');

Route::resource('admin/configuracion', 							ControladorConfiguracion::class)->middleware('admin');
Route::get('admin/configuracion/eliminar/logo',					[ControladorConfiguracion::class ,'eliminar_logo'])->middleware('admin');
Route::get('admin/generar/codigo/',                             [ControladorPrincipal::class ,'generar_codigo'])->middleware('admin');

Route::get('admin/error/soporte',                               [ControladorError::class , 'soporte'])->middleware('admin');
Route::resource('admin/error', 									ControladorError::class)->middleware('admin');
Route::post('admin/error/responder/{id}',						[ControladorError::class ,'responder'])->middleware('admin');
Route::get('admin/error/captura/{ID}',                          [ControladorError::class , 'captura'])->middleware('admin');
Route::get('admin/error/adjunto/{ID}',                          [ControladorError::class , 'adjunto'])->middleware('admin');

Route::resource('admin/notificacion',							ControladorNotificacion::class)->middleware('admin');
Route::get('admin/notificacion/cambiar/pendiente',              [ControladorNotificacion::class, 'pendiente'])->middleware('admin');
Route::get('admin/cargar/notificacion/',                        [ControladorNotificacion::class, 'cargar_notificacion']);

Route::resource('admin/mensaje',								ControladorMensaje::class)->middleware('admin');
Route::get('admin/mensaje/cambiar/pendiente',                   [ControladorMensaje::class, 'pendiente'])->middleware('admin');
Route::get('admin/cargar/mensaje/',                             [ControladorMensaje::class, 'cargar_mensaje']);

Route::resource('admin/web',									ControladorLanding::class)->middleware('admin');
Route::resource('admin/web',									ControladorLanding::class)->middleware('admin');
Route::post('admin/web/codigo', 								[ControladorLanding::class , 'codigo'])->middleware('admin');
Route::post('admin/web/guardar', 								[ControladorLanding::class , 'guardar'])->middleware('admin');

Route::resource('admin/tema',									ControladorTema::class)->middleware('admin');
Route::get('admin/tema/instalar/{id}', 							[ControladorTema::class , 'instalar'])->middleware('admin');
Route::get('admin/tema/activar/{id}', 							[ControladorTema::class , 'activar'])->middleware('admin');
Route::get('admin/tema/descargar/{id}', 						[ControladorTema::class , 'descargar'])->middleware('admin');
Route::get('admin/tema/resetear/actual', 						[ControladorTema::class , 'reinstalar'])->middleware('admin');
Route::get('admin/tema/pago/exitoso', 							[ControladorTema::class , 'pago_exitoso'])->middleware('admin');
Route::get('admin/tema/pago/pendiente', 						[ControladorTema::class , 'pago_pendiente'])->middleware('admin');
Route::get('admin/tema/pago/fallido', 							[ControladorTema::class , 'pago_fallido'])->middleware('admin');

Route::resource('admin/plugin',									ControladorPlugin::class)->middleware('admin');
Route::get('admin/plugin/instalar/{id}', 						[ControladorPlugin::class , 'instalar'])->middleware('admin');
Route::get('admin/plugin/activar/{id}', 						[ControladorPlugin::class , 'activar'])->middleware('admin');
Route::get('admin/plugin/desactivar/{id}', 						[ControladorPlugin::class , 'desactivar'])->middleware('admin');
Route::get('admin/plugin/pago/exitoso', 						[ControladorPlugin::class , 'pago_exitoso'])->middleware('admin');
Route::get('admin/plugin/pago/pendiente', 						[ControladorPlugin::class , 'pago_pendiente'])->middleware('admin');
Route::get('admin/plugin/pago/fallido', 						[ControladorPlugin::class , 'pago_fallido'])->middleware('admin');

Route::get('admin/mercadopago', 								[ControladorMercadoPago::class , 'conexion'])->middleware('admin');
Route::get('admin/mercadopago/desconectar',						[ControladorMercadoPago::class ,'desconexion'])->middleware('admin');

Route::resource('admin/cupon',                                  ControladorCupon::class)->middleware('admin');
Route::get('admin/cupon/cambiar/{id}',                          [ControladorCupon::class ,'cambiar'])->middleware('admin');

/* Controladores de de venta*/

Route::get('checkout/pago_exitoso', 							[ControladorPago::class , 'pago_exitoso']);
Route::get('checkout/pago_pendiente', 							[ControladorPago::class , 'pago_pendiente']);
Route::get('checkout/pago_fallido', 							[ControladorPago::class , 'pago_fallido']);

Route::get('checkout/{ID}', 									[ControladorPago::class , 'ver_checkout']);
Route::post('checkout/{ID}', 									[ControladorPago::class , 'checkout']);
Route::get('checkout/pago/{ID}', 								[ControladorPago::class , 'ver_checkout_pago']);
Route::post('checkout/pago/{ID}', 								[ControladorPago::class , 'checkout_pago']);

/* Controladores de Ayuda*/

Route::get('ayuda', 											[ControladorAyudaPrincipal::class, 'index']);
Route::get('ayuda/buscar', 										[ControladorAyudaPrincipal::class, 'buscar']);
Route::get('ayuda/entrada/{id}', 								[ControladorAyudaPrincipal::class, 'entrada']);
Route::get('ayuda/categoria/{id}',								[ControladorAyudaPrincipal::class, 'categoria']);

/* Controladores de ROOT*/

Route::get('/root',                                         [ControladorPrincipal::class ,'dashboard'])->middleware('root');
Route::resource('root/empresa', 							RootControladorEmpresas::class)->middleware('root');
Route::post('root/empresa/controlar/{ID}',                  [RootControladorEmpresas::class , 'control'])->middleware('root');
Route::get('root/empresa/deshabilitar/{ID}',                [RootControladorEmpresas::class , 'deshabilitar'])->middleware('root');
Route::resource('root/usuario', 							RootControladorUsuarios::class)->middleware('root');
Route::resource('root/venta', 								RootControladorVentas::class)->middleware('root');
Route::resource('root/codigo', 								RootControladorCodigos::class)->middleware('root');
Route::resource('root/opcion', 								RootControladorOpciones::class)->middleware('root');
Route::resource('root/mensaje/error',						RootControladorMensajesError::class)->middleware('root');
Route::resource('root/error',                               RootControladorError::class)->middleware('root');
Route::get('root/error/captura/{ID}',						[RootControladorError::class , 'captura'])->middleware('root');
Route::get('root/error/tomar/{ID}',							[RootControladorError::class , 'tomar'])->middleware('root');
Route::get('root/error/resolver/{ID}',						[RootControladorError::class , 'resolver'])->middleware('root');
Route::get('root/error/reabrir/{ID}',						[RootControladorError::class , 'reabrir'])->middleware('root');
Route::get('root/perfil', 									[RootControladorUsuarios::class , 'get_perfil'])->middleware('root');
Route::post('root/perfil', 									[RootControladorUsuarios::class , 'set_perfil'])->middleware('root');
Route::get('root/administrar', 								[RootControladorAdministrar::class , 'index'])->middleware('root');
Route::get('root/administrar/actualizar',                   [RootControladorAdministrar::class , 'actualizar'])->middleware('root');
Route::post('root/administrar/email', 						[RootControladorAdministrar::class , 'email'])->middleware('root');
Route::resource('root/ayuda', 								RootControladorAyudaCategoria::class)->middleware('root');
Route::resource('root/ayuda/entrada', 						RootControladorAyudaEntrada::class)->middleware('root');
Route::resource('root/log',                                 RootControladorLog::class)->middleware('root');


/* Controladores de plugins*/

/* Controlador Plugin Blog*/

Route::resource('admin/blog/entrada',                           BlogControladorEntrada::class)->middleware(['admin', 'plugin.blog']);
Route::resource('admin/blog/comentario',                        BlogControladorComentario::class)->middleware(['admin', 'plugin.blog']);
Route::resource('admin/blog/categoria',					        BlogControladorCategoria::class)->middleware(['admin', 'plugin.blog']);

Route::get('blog',                                              [BlogControladorPrincipal::class , 'index'])->middleware('plugin.blog');
Route::get('blog/categoria/{ID}',                               [BlogControladorPrincipal::class , 'categoria'])->middleware('plugin.blog');
Route::post('blog/comentario/{ID}',                             [BlogControladorPrincipal::class , 'comentario'])->middleware('plugin.blog');
Route::get('blog/{ID}',                                         [BlogControladorPrincipal::class , 'entrada'])->middleware('plugin.blog');

/* Controlador Plugin WPP*/

Route::resource('admin/ventaPorWpp',                            VentaPorWppControladorPrincipal::class)->middleware(['admin', 'plugin.VentaPorWpp']);
Route::get('ventaPorWpp/{ID}',                                  [VentaPorWppControladorPrincipal::class , 'venta'])->middleware('plugin.VentaPorWpp');

/* Controladores de las landing de las empresas*/

Route::get('categoria/{ID}', 									[ControladorPrincipal::class , 'categoria']);
Route::get('productos', 										[ControladorPrincipal::class , 'productos']);
Route::get('producto/{ID}', 									[ControladorPrincipal::class , 'producto']);
Route::get('carrito', 											[ControladorPrincipal::class , 'carrito']);
Route::get('pagina/{ID}', 										[ControladorPrincipal::class , 'pagina']);
Route::get('comprar_ahora/{ID}', 								[ControladorPrincipal::class , 'comprar_ahora']);
Route::get('comprar', 											[ControladorPrincipal::class , 'comprar']);
Route::post('agregar_carrito', 									[ControladorPrincipal::class , 'agregar_carrito']);
Route::get('eliminar_carrito/{ID}', 							[ControladorPrincipal::class , 'eliminar_carrito']);
Route::get('vaciar_carrito',		 							[ControladorPrincipal::class , 'vaciar_carrito']);
Route::post('contacto', 										[ControladorPrincipal::class , 'contacto']);
Route::post('contacto_empresa', 								[ControladorPrincipal::class , 'contacto_empresa']);
Route::post('visita', 											[ControladorPrincipal::class , 'visita']);
Route::post('newsletter', 										[ControladorPrincipal::class , 'newsletter']);
Route::get('eticket/{ID}', 										[ControladorPrincipal::class , 'eticket']);
Route::get('{ID}', 												[ControladorPrincipal::class , 'url']);
