<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CrearTodosLosEnlaces extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'enlaces:crear';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Crea un enlace simbolico para cada empresa';

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
        shell_exec('ln -s ~/apps/ttf/resources/views/empresas ~/apps/ttf/public/empresas');
        shell_exec('ln -s ~/apps/ttf/resources/views/temas ~/apps/ttf/public/temas');

        $this->info('Se crean enlaces simbolicos');
    }
}
