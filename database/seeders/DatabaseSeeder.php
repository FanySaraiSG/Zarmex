<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            ColorSeeder::class,
            CategoriaSeeder::class,
            ProductoConImagenSeeder::class,
            EmployeeSeeder::class,
            TopProductSeeder::class,
            ImagenesSeeder::class,
            ImagenesCarruselSeeder::class,
            PromotionSeeder::class,
        ]);
    }
}
