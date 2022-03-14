<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class TemaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('temas')->insert([
            'nombre' => "Default",
            'tipo' => 'publico',
            'carpeta' => 'default',
            'precio' => '0',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        \DB::table('temas')->insert([
            'nombre' => "Gzael",
            'tipo' => 'publico',
            'carpeta' => 'gzael',
            'precio' => '0',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

    }
}
