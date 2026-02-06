<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = Carbon::now();

        DB::table('employees')->insert([
            [
                'id_empleado' => 1,
                'name' => 'Josue Daniel De Luna',
                'email' => 'josueluna.zarmex@gmail.com',
                'password' => Hash::make('Femsa.02'),
                'telefono' => '5533026467',
                'rol' => 'admin',
                'creado_en' => $now,
                'actualizado_en' => $now,
            ],
            [
                'id_empleado' => 2,
                'name' => 'Contacto Tecnico',
                'email' => 'contacto.zarmex@gmail.com',
                'password' => Hash::make('Contacto.03'),
                'telefono' => '5581366555',
                'rol' => 'tecnico',
                'creado_en' => $now,
                'actualizado_en' => $now,
            ],
            [
                'id_empleado' => 3,
                'name' => 'Zarmex',
                'email' => 'zarmex.mexico@gmail.com',
                'password' => Hash::make('Zarmex.04'),
                'telefono' => '5581366555',
                'rol' => 'admin',
                'creado_en' => $now,
                'actualizado_en' => $now,
            ],
            [
                'id_empleado' => 4,
                'name' => 'Soporte',
                'email' => 'soporte.zarmex@gmail.com',
                'password' => Hash::make('Soporte.05'),
                'telefono' => '5581366555',
                'rol' => 'soporte',
                'creado_en' => $now,
                'actualizado_en' => $now,
            ],
        ]);
    }
}