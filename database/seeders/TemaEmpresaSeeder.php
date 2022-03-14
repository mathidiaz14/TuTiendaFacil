<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class TemaEmpresaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         \DB::table('empresa_tema')->insert([
            'empresa_id' => '1',  
            'tema_id' => '1',
            'estado' => 'activo',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
