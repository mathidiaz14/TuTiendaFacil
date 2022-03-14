<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CategoriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('categorias')->insert([
            'titulo' => "Categoria 1",
            'tipo' => 'productos',
            'observacion' => "Observacion de la categoria 1",
            'empresa_id' => '1',  
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        \DB::table('categorias')->insert([
            'titulo' => "Categoria 2",
            'tipo' => 'productos',
            'observacion' => "Observacion de la categoria 2",
            'empresa_id' => '1',  
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        \DB::table('categorias')->insert([
            'titulo' => "Categoria 3",
            'tipo' => 'productos',
            'observacion' => "Observacion de la categoria 3",
            'empresa_id' => '1',  
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
