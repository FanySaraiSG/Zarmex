<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ColorSeeder extends Seeder
{
    public function run()
{
    $categorias = [
        [
            'id_categoria' => 'ZAR-CQP', 
            'nombre' => 'Quiropráctica', 
            'descripcion' => 'Equipos de quiropráctica',
            'creado_en' => now(), // Asegúrate de usar tus nombres de columna correctos
            'actualizado_en' => now()
        ],
        // ... pon aquí el resto de tus categorías ...
    ];

    // Si 'id_categoria' ya existe, actualiza el nombre y la descripción en vez de tronar
    DB::table('categorias')->upsert($categorias, ['id_categoria'], ['nombre', 'descripcion', 'actualizado_en']);
}
}
