<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Venta;
use MercadoPago;
use DB;

class ConsultarPagosPendientes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pagos:pendientes';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Consultar pagos pendientes para saber si se acreditaron en MercadoPago';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        //Controlo el estado del pago de las ventas que quedaron en pendiente

        $ventas = Venta::where('estado', 'pendiente')->get();

        $contador_ventas = 0;

        foreach ($ventas as $venta)
        {
            if($venta->empresa->configuracion->mp_access_token != null)
            {
                MercadoPago\SDK::configure(['ACCESS_TOKEN' => $venta->empresa->configuracion->mp_access_token]);
                $payment = MercadoPago\Payment::find_by_id($venta->mp_id);
                
                if($payment->status == "approved")
                {
                    $venta->estado = "aprobado";
                    $venta->save();

                    $titulo     = "Pago aprobado";
                    $contenido  = "Se aprobo el pago de la venta #".$venta->codigo;
                    $url        = '/admin/venta/'.$venta->id;

                    crear_notificacion($titulo, $contenido, $url,$venta->empresa_id);

                    $contador_ventas += 1;

                }elseif($payment->status == "rejected")
                {
                    $venta->estado = "rechazado";
                    $venta->save();

                    $titulo     = "Pago rechazado";
                    $contenido  = "Se rechazo el pago de la venta #".$venta->codigo;
                    $url        = '/admin/venta/'.$venta->id;

                    crear_notificacion($titulo, $contenido, $url,$venta->empresa_id);
                }
            }
        }


        //Controlo el estado del pago de los plugins que se hicieron por MP
        \MercadoPago\SDK::setAccessToken(env('MP_ACCESS_TOKEN'));

        $plugins = DB::table('empresa_plugin')->where('estado', 'pendiente')->get();
        
        $contador_plugins = 0;

        foreach ($plugins as $plugin) 
        {    
            $payment = MercadoPago\Payment::find_by_id($plugin->mp_id);

            if($payment->status == "approved")
            {
                $plugin->estado = "instalado";
                $plugin->save();

                $titulo     = "Pago aprobado";
                $contenido  = "Se aprobo el pago de un plugin";
                $url        = url('/admin/plugin');

                crear_notificacion($titulo, $contenido, $url, $plugin->empresa_id);   

                $contador_plugins += 1;

            }elseif($payment->status == "rejected")
            {
                $plugin->delete();

                $titulo     = "Pago rechazado";
                $contenido  = "Se rechazo el pago de un plugin";
                $url        = url('/admin/plugin');

                crear_notificacion($titulo, $contenido, $url, $plugin->empresa_id);   
                
            } 
        }

        //Controlo el estado del pago de los temas que se hicieron por MP

        $temas = DB::table('empresa_tema')->where('estado', 'pendiente')->get();
        
        $contador_temas = 0;

        foreach ($temas as $tema) 
        {    
            $payment = MercadoPago\Payment::find_by_id($tema->mp_id);

            if($payment->status == "approved")
            {
                $tema->estado = "instalado";
                $tema->save();

                $titulo     = "Pago aprobado";
                $contenido  = "Se aprobo el pago de un tema";
                $url        = url('/admin/tema');

                crear_notificacion($titulo, $contenido, $url, $tema->empresa_id);   

                $contador_temas ++;

            }elseif($payment->status == "rejected")
            {
                $tema->delete();

                $titulo     = "Pago rechazado";
                $contenido  = "Se rechazo el pago de un tema";
                $url        = url('/admin/tema');

                crear_notificacion($titulo, $contenido, $url, $tema->empresa_id);   
                
            } 
        }

        //Controlo el pago de las empresas

        $empresas = DB::table('empresas')->where('pago', 'pendiente')->get();
        
        $contador_empresas = 0;

        foreach ($empresas as $empresa) 
        {    
            $payment = MercadoPago\Payment::find_by_id($empresa->mp_id);

            if($payment->status == "approved")
            {
                $empresa->pago  = "aprobado";
                $empresa->mp_id = null;
                $tema->save();

                $contenido = [
                    "nombre" => $empresa->nombre,
                ];
                
                email("email.nueva_empresa.pago_aprobado", "Pago aprobado - TuTiendaFacil.uy", $contenido, $empresa->configuracion->email_admin);

                $contador_empresas ++;

            }elseif($payment->status == "rejected")
            {
                $empresa->pago = "rechazado";
                $empresa->mp_id = null;
                $empresa->save();

                $contenido = [
                    "nombre" => $empresa->nombre,
                ];
                
                email("email.nueva_empresa.pago_rechazado", "Pago rechazado - TuTiendaFacil.uy", $contenido, $empresa->configuracion->email_admin);
            } 
        }

        $this->info('Se aprobaron '.$contador_ventas.' ventas de un total de '.$ventas->count());
        $this->info('Se aprobaron '.$contador_plugins.' plugins de un total de '.$plugins->count());
        $this->info('Se aprobaron '.$contador_temas.' temas de un total de '.$temas->count());
        $this->info('Se aprobaron '.$contador_empresas.' empresas de un total de '.$empresas->count());
    }
}
