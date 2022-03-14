<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Artisan;
use File;
use Storage;

class CrearPlugin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'plugin:crear {nombre}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Comando que crea todos los archivos para un Plugin';

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
        $nombre = $this->argument('nombre');

        Artisan::call('make:controller Plugins/'.$nombre."/".$nombre."ControladorPrincipal --resource");
        Artisan::call('make:model Plugins/'.$nombre."/".$nombre." -m");
        Artisan::call('make:middleware Plugins/'.$nombre);

        $remplazar = "
        if(Auth::check())
            \$empresa = Auth::user()->empresa;
        else
            \$empresa = empresa();

        \$plugin = \$empresa->plugins->where('carpeta', 'blog')->first();

        if((\$plugin != null) and (\$plugin->carpeta == 'blog') and (\$plugin->pivot->estado == 'activo'))
            return \$next(\$request);
                
        return redirect('/');
        ";

        $contenido = file_get_contents(app_path('Http/Middleware/Plugins/'.$nombre.".php"));

        $contenido = str_replace("return \$next(\$request);", $remplazar, $contenido);

        File::put(app_path('Http/Middleware/Plugins/'.$nombre.".php"), $contenido);

    }
}
