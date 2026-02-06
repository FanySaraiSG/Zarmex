<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ImagenesSeeder extends Seeder
{
    public function run()
    {
        DB::table('imagenes')->insert([
            [
                'id' => 1,
                'nombre' => '1742439791_Captura de pantalla 2025-01-19 134751.png',
                'imagen_url' => 'imagenes/1742439791_Captura de pantalla 2025-01-19 134751.png',
                'seccion' => 'logo',
                'created_at' => Carbon::create(2025, 3, 22, 0, 8, 37),
                'updated_at' => Carbon::create(2025, 3, 22, 0, 8, 37),
            ],
            [
                'id' => 3,
                'nombre' => 'banner.jpeg',
                'imagen_url' => 'imagenes/1742582362_1742518101_banner.jpeg',
                'seccion' => 'banner',
                'created_at' => Carbon::create(2025, 3, 22, 0, 38, 59),
                'updated_at' => Carbon::create(2025, 3, 22, 0, 39, 22),
            ],
            [
                'id' => 4,
                'nombre' => '1742440357_Nosotros_Principal.jpg',
                'imagen_url' => 'imagenes/1742440357_Nosotros_Principal.jpg',
                'seccion' => 'nosotros_banner',
                'created_at' => Carbon::create(2025, 3, 22, 0, 43, 50),
                'updated_at' => Carbon::create(2025, 3, 22, 0, 43, 50),
            ],
            [
                'id' => 5,
                'nombre' => 'bienvenida.png',
                'imagen_url' => 'imagenes/bienvenida.png',
                'seccion' => 'banner',
                'created_at' => Carbon::create(2025, 3, 29, 4, 36, 55),
                'updated_at' => Carbon::create(2025, 3, 29, 4, 36, 55),
            ],
        ]);
    }
}