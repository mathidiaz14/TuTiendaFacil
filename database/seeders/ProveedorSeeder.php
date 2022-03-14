<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ProveedorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('proveedors')->insert([
            'nombre' => "Proveedor 1",
            'rut' => '123456789',
            'telefono' => "+59812345678",
            'direccion' => "Dirección proveedor 1",
            'empresa_id' => '1',  
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        \DB::table('proveedors')->insert([
            'nombre' => "Proveedor 2",
            'rut' => '987654321',
            'telefono' => "+59887654321",
            'direccion' => "Dirección proveedor 2",
            'empresa_id' => '1',  
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        \DB::table('proveedors')->insert([
            'nombre' => "Proveedor 3",
            'rut' => '456123789',
            'telefono' => "+59878945612",
            'direccion' => "Dirección proveedor 3",
            'empresa_id' => '1',  
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
