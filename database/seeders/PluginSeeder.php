<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class PluginSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        \DB::table('plugins')->insert([
            'nombre' => "Blog",
            'tipo' => 'publico',
            'carpeta' => 'blog',
            'precio' => '0',
            'imagen' => 'img/plugins/Blog.jpg',
            'descripcion' => 'Crea un blog en tu tienda.',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        \DB::table('plugins')->insert([
            'nombre' => "Venta por WhatsAPP",
            'tipo' => 'publico',
            'carpeta' => 'VentaPorWpp',
            'precio' => '0',
            'imagen' => 'img/plugins/wpp.jpg',
            'descripcion' => 'Aparece un bóton de comprar por WhatsAPP junto al botón de comprar',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
