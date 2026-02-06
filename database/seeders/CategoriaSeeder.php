<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CategoriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = Carbon::now();

        DB::table('categorias')->insert([
            [
                'id_categoria' => 'ZAR-CQP',
                'nombre' => 'Quiropráctica',
                'descripcion' => 'Equipos de quiropráctica',
                'creado_en' => $now,
                'actualizado_en' => $now,
            ],
            [
                'id_categoria' => 'ZAR-FTA',
                'nombre' => 'Fisioterapia',
                'descripcion' => 'Equipos de Fisioterapia',
                'creado_en' => $now,
                'actualizado_en' => $now,
            ],
            [
                'id_categoria' => 'ZAR-GNA',
                'nombre' => 'Ginecología',
                'descripcion' => 'Equipos de Ginecología',
                'creado_en' => $now,
                'actualizado_en' => $now,
            ],
            [
                'id_categoria' => 'ZAR-ODN',
                'nombre' => 'Odontología',
                'descripcion' => 'Equipos de Odontología',
                'creado_en' => $now,
                'actualizado_en' => $now,
            ],
            [
                'id_categoria' => 'ZAR-OTN',
                'nombre' => 'Otorrinolaringología',
                'descripcion' => 'Equipos de Otorrinolaringología',
                'creado_en' => $now,
                'actualizado_en' => $now,
            ],
            [
                'id_categoria' => 'ZAR-PDA',
                'nombre' => 'Podología',
                'descripcion' => 'Equipos de Podología',
                'creado_en' => $now,
                'actualizado_en' => $now,
            ],
        ]);
    }
}