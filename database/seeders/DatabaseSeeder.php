<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
         $this->call([
		        UserSeeder::class,
                EmpresaSeeder::class,
                ConfiguracionSeeder::class,
                CategoriaSeeder::class,
                ProveedorSeeder::class,
                LocalSeeder::class,
                OpcionSeeder::class,
                TemaSeeder::class,
                TemaEmpresaSeeder::class,
                PluginSeeder::class,
		    ]);
    }
}
