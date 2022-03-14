<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Venta;
use App\Models\Notificacion;
use App\Models\Cliente;
use App\Models\Stock;
use App\Models\Cupon;
use Carbon\Carbon;
use MercadoPago;
use Http;

class ControladorPago extends Controller
{
    private $path = "compra.";

    public function ver_checkout($id)
    {
        $venta = Venta::where('codigo', $id)->first();

        if($venta != null)
            return view($this->path.'index', compact('venta'));

        return redirect('/');
    }

    public function checkout($id, Request $request)
    {
        $venta  = Venta::where('codigo', $id)->first();

        if($venta == null)
        {
            error('Error al procesar los datos');
            return back();
        }

        if($request->cupon != null)
        {
            $cupon = $venta->empresa->cupones->where('codigo', $request->cupon)->first();
            
            if(($cupon == null) or ($cupon->estado == "inactivo"))
            {
                error("El cupón no esta disponible");
                return back();
            }else
            {

                $venta->descuento = ($venta->precio * $cupon->descuento) / 100;
                $venta->save();

                if($cupon->cantidad == 1)
                    $cupon->estado = "inactivo";

                $cupon->cantidad -= 1;
                $cupon->save();
            }
        }

        $cliente = Cliente::where('email', $request->email)->first();

        if($cliente != null) 
            $venta->cliente_id      = $cliente->id;
        
        $venta->entrega             = $request->entrega;
        $venta->cliente_nombre      = $request->name;
        $venta->cliente_apellido    = $request->surname;
        $venta->cliente_telefono    = $request->telefono;
        $venta->cliente_email       = $request->email;
        $venta->cliente_ciudad      = $request->ciudad;
        $venta->cliente_direccion   = $request->direccion;
        $venta->cliente_apartamento = $request->apartamento;
        $venta->cliente_observacion = $request->observacion;
        $venta->local_id            = $request->local;
        $venta->save();

        return redirect('checkout/pago/'.$venta->codigo);
    }

    public function ver_checkout_pago($id)
    {
        $venta      = Venta::where('codigo', $id)->first();
        
        if($venta == null)      
            return abort(404);
        
        $empresa    = $venta->empresa;
            
        if(($empresa->configuracion == null) or ($empresa->configuracion->mp_access_token == null))
            return abort(404);

        MercadoPago\SDK::configure(['ACCESS_TOKEN' => $empresa->configuracion->mp_access_token]);

        $preference = new MercadoPago\Preference();

        $item                           = new MercadoPago\Item();
        $item->title                    = $empresa->nombre." - #".$venta->codigo;
        $item->quantity                 = 1;
        $item->currency_id              = "UYU";
        $item->unit_price               = $venta->precio - $venta->descuento;
        
        $preference->items              = array($item);
        $preference->external_reference = $venta->codigo; 
        $preference->back_urls          = array(
                                            "success" => url('checkout/pago_exitoso'),
                                            "failure" => url('checkout/pago_fallido'),
                                            "pending" => url('checkout/pago_pendiente')
                                        );
        $preference->auto_return        = "approved";
        $preference->save();

        return view($this->path.'pago', compact('venta', 'preference'));
    }

    private function venta_crear_notificacion($venta)
    {
        $titulo     = "Nuevo pedido";
        $contenido  = "Tienes un nuevo pedido, el numero es #".$venta->codigo;
        $url        = '/admin/venta/'.$venta->id;

        crear_notificacion($titulo, $contenido, $url,$venta->empresa_id);

        return true;
    }

    private function venta_guardar_cliente($venta)
    {
        $nuevo_cliente                  = new Cliente();
        $nuevo_cliente->nombre          = $venta->cliente_nombre;
        $nuevo_cliente->apellido        = $venta->cliente_apellido;
        $nuevo_cliente->ciudad          = $venta->cliente_ciudad;
        $nuevo_cliente->direccion       = $venta->cliente_direccion;
        $nuevo_cliente->apartamento     = $venta->cliente_apartamento;
        $nuevo_cliente->telefono        = $venta->cliente_telefono;
        $nuevo_cliente->email           = $venta->cliente_email;
        $nuevo_cliente->empresa_id      = $venta->empresa_id;
        $nuevo_cliente->save();

        $venta->cliente_id              = $nuevo_cliente->id;
        $venta->save();

        return true;
    }

    public function pago_exitoso(Request $request)
    {
        $venta              = Venta::where('codigo',$request->external_reference)->first();

        if($venta == null)
            return abort(404);

        $venta->estado      = "aprobado";
        $venta->mp_id       = $request->payment_id;
        $venta->save();

        foreach($venta->productos as $producto)
        {
            $this->comprobar_producto_minimo($producto, $producto->pivot->cantidad);                
            
            if($producto->pivot->variante_id == null)
            {
                if($producto->cantidad > 0)
                {
                    $producto->cantidad -= $producto->pivot->cantidad;
                    $producto->save();
                }
            }else
            {
                $variante = Stock::find($producto->pivot->variante_id);
                
                if($variante->cantidad > 0)
                {
                    $variante->cantidad -= $producto->pivot->cantidad;
                    $variante->save();
                }
            }
        }

        $this->venta_crear_notificacion($venta);
        
        if($venta->cliente_id == null)
            $this->venta_guardar_cliente($venta);

        $contenido = [
            "titulo"    => "Comprobante de compra en ".$venta->empresa->nombre,
            "venta"     => $venta
        ];

        email('email.compra', "Comprobante de compra", $contenido, $venta->cliente_email);
        
        return redirect('eticket/'.$venta->codigo);
    }

    public function pago_pendiente(Request $request)
    {
        $venta              = Venta::where('codigo',$request->external_reference)->first();

        if($venta == null)
            return abort(404);

        $venta->estado      = "pendiente";
        $venta->mp_id       = $request->payment_id;
        $venta->save();

        $this->venta_crear_notificacion($venta);
        
        if($venta->cliente_id == null)
            $this->venta_guardar_cliente($venta);
        
        return redirect('eticket/'.$venta->codigo);
    }

    public function pago_fallido(Request $request)
    {
        $venta              = Venta::where('codigo',$request->external_reference)->first();
        
        if($venta == null)
            return abort(404);
        
        $venta->estado      = "rechazado";
        $venta->save();
        
        error("No se pudo procesar el pago.");
        return back();
    }

    public function comprobar_producto_minimo($producto, $venta)
    {
        if($producto->variantes->count() > 0)
            $cantidad = $producto->variantes->sum('cantidad');
        else
            $cantidad = $producto->cantidad;

        if(($cantidad > $producto->minimo_producto) and ($cantidad - $venta <= $producto->minimo_producto))
        {
            $titulo     = "Un producto llego al minimo";
            $contenido  = "El producto ".$producto->nombre." llego al minimo establecido";
            $url        = '/admin/producto/'.$producto->id.'/edit';

            crear_notificacion($titulo, $contenido, $url,$producto->empresa_id);

            return true; 
        }
    }

}
