<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ColorSeeder extends Seeder
{
    public function run()
    {
        $colors = [
            ['id_color' => '283032', 'nombre' => 'Azabache'],
            ['id_color' => '4c88aa', 'nombre' => 'Rey'],
            ['id_color' => '739f6a', 'nombre' => 'Verde Limón'],
            ['id_color' => '7c9b93', 'nombre' => 'Gris Agua'],
            ['id_color' => 'b84a4b', 'nombre' => 'Rojo Saf'],
            ['id_color' => 'd9535a', 'nombre' => 'Rojo Medio'],
            ['id_color' => 'e15570', 'nombre' => 'Magenta'],
            ['id_color' => 'e57e44', 'nombre' => 'Mandarina'],
            ['id_color' => 'e9b851', 'nombre' => 'Melón'],
            ['id_color' => 'ed455c', 'nombre' => 'Bermellón'],
            ['id_color' => 'eeb451', 'nombre' => 'Amarillo KOD'],
        ];

        foreach ($colors as $color) {
            DB::table('colors')->insert([
                'id_color' => $color['id_color'],
                'nombre' => $color['nombre'],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}
