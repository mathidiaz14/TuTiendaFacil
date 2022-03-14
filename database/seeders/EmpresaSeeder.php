<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class EmpresaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('empresas')->insert([
            'nombre' => "Moriarty",
            'url' => 'moriarty.local',
            'carpeta' => 'default',
            'estado' => 'completo',
            'expira' => now()->addYear(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
