<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('users')->insert([
            'nombre' => "Superusuario",
            'email' => 'admin@admin.com',
            'password' => bcrypt('123456'),
            'tipo' => 'root',  
            'empresa_id' => '0',  
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        \DB::table('users')->insert([
            'nombre' => "Administrador Moriarty",
            'email' => 'admin@moriarty.uy',
            'password' => bcrypt('123456'),
            'tipo' => 'admin',  
            'empresa_id' => '1',  
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
