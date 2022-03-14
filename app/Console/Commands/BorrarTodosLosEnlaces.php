<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class BorrarTodosLosEnlaces extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'enlaces:borrar';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Borra todos los enlaces simbolicos';

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
        shell_exec('rm -r ~/apps/ttf/public/empresas');
        shell_exec('rm -r ~/apps/ttf/public/temas');

        $this->danger('Se eliminaron las carpetas public/empresas y public/temas');
    }
}
