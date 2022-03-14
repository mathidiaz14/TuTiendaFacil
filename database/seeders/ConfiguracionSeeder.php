<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ConfiguracionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('configuracions')->insert([
            'empresa_id' => '1',  
            'titulo' => "Moriarty.uy",
            'descripcion' => 'Tejiendo respetando los procesos, de forma lenta y consciente',
            'email_admin' => "admin@moriarty.uy",
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
