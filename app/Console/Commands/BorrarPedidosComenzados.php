<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Venta;
use Carbon\Carbon;

class BorrarPedidosComenzados extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pedidos:comenzados';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Borra los pedidos comenzados con mas de 24 horas de diferencia';

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
        $ventas     = Venta::where('estado', 'comenzado')->get();
        $now        = Carbon::now();

        $count      = 0;
        $recordado  = 0;

        foreach($ventas as $venta)
        {
            if($now->diffInHours($venta->created_at) >= 24)
            {
                if(($venta->cliente_email == null) or ($now->diffInHours($venta->created_at) >= 47))
                {
                    $venta->delete();
                    $count ++;
                }else
                {
                    $contenido = [
                        "pagina"    => $venta->empresa->url,
                        "url"       => url('checkout/pago', $venta->codigo),
                    ];
                    
                    email("email.recordatorio_compra", "Finaliza tu compra", $contenido, $venta->cliente_email);

                    $recordado ++;
                }
            }
        }

        if($count > 0)
            $this->info('Se eliminaron '.$count.' ventas');
        else
            $this->info('No se eliminaron ventas');

        if($recordado > 0)
            $this->info('Se recordaron '.$recordado.' ventas');

    }
}
