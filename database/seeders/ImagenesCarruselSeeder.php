<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ImagenesCarruselSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $imagenes = [
            [
                'nombre' => 'bienvenida',
                'imagen_url' => 'imagenes/Carrusel/bienvenida.jpeg',
                'seccion' => 'banner',
                'link_url' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Calidad',
                'imagen_url' => 'imagenes/Carrusel/Calidad.jpeg',
                'seccion' => 'banner',
                'link_url' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Equipos',
                'imagen_url' => 'imagenes/Carrusel/Equipos.jpeg',
                'seccion' => 'banner',
                'link_url' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Experiencia',
                'imagen_url' => 'imagenes/Carrusel/Experiencia.jpeg',
                'seccion' => 'banner',
                'link_url' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Financiamiento',
                'imagen_url' => 'imagenes/Carrusel/Financiamiento.jpeg',
                'seccion' => 'banner',
                'link_url' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Por que',
                'imagen_url' => 'imagenes/Carrusel/Por que.jpeg',
                'seccion' => 'banner',
                'link_url' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        // Vaciamos los registros anteriores de la sección banner para que no se dupliquen
        DB::table('imagenes')->where('seccion', 'banner')->delete();

        // Insertamos las imágenes con las extensiones correctas
        DB::table('imagenes')->insert($imagenes);
    }
}