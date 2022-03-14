<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class OpcionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('opcions')->insert([
            'plan1' => '1',  
            'plan2' => '2',  
            'plan3' => '3',  
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
