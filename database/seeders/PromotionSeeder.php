<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PromotionSeeder extends Seeder
{
    public function run()
    {
        $promotions = [
            ['id' => 1, 'nombre' => 'Promoción 1', 'imagen_url' => null, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 2, 'nombre' => 'Promoción 2', 'imagen_url' => null, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 3, 'nombre' => 'Promoción 3', 'imagen_url' => null, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 4, 'nombre' => 'Promoción 4', 'imagen_url' => null, 'created_at' => now(), 'updated_at' => now()],
        ];

        // Insertamos los 4 registros base ignorando si ya existen
        DB::table('promociones')->insertOrIgnore($promotions);
    }
}