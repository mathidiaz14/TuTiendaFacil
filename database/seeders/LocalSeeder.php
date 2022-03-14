<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class LocalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('locals')->insert([
            'empresa_id' => "1",
            'nombre' => 'Local Central',
            'direccion' => 'Dirección 1234',  
            'localidad' => 'Montevideo',  
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        \DB::table('locals')->insert([
            'empresa_id' => "1",
            'nombre' => 'Local 2',
            'direccion' => 'Dirección 4321',  
            'localidad' => 'Canelones',  
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
