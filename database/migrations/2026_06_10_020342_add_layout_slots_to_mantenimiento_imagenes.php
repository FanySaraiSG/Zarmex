<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Agrega soporte para hasta 3 imágenes por columna (izquierda_1..3, derecha_1..3)
     * y registros de configuración de layout (config_layout_izq, config_layout_der).
     *
     * Las posiciones antiguas (izquierda, derecha_superior, derecha_inferior)
     * se migran automáticamente a los nuevos nombres.
     */
    public function up(): void
    {
        // 1. Quitar el unique de posicion para poder tener los nuevos valores
        Schema::table('mantenimiento_imagenes', function (Blueprint $table) {
            $table->dropUnique(['posicion']);
        });

        // 2. Migrar registros viejos a los nuevos nombres de posición
        DB::table('mantenimiento_imagenes')
            ->where('posicion', 'izquierda')
            ->update(['posicion' => 'izquierda_1']);

        DB::table('mantenimiento_imagenes')
            ->where('posicion', 'derecha_superior')
            ->update(['posicion' => 'derecha_1']);

        DB::table('mantenimiento_imagenes')
            ->where('posicion', 'derecha_inferior')
            ->update(['posicion' => 'derecha_2']);

        // 3. Volver a poner el unique con los nuevos valores
        Schema::table('mantenimiento_imagenes', function (Blueprint $table) {
            $table->unique('posicion');
        });

        // 4. Insertar registros de configuración de layout con defaults
        DB::table('mantenimiento_imagenes')->insertOrIgnore([
            [
                'posicion'    => 'config_layout_izq',
                'ruta_imagen' => 'config',
                'orden'       => 1,
                'activo'      => false,
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'posicion'    => 'config_layout_der',
                'ruta_imagen' => 'config',
                'orden'       => 2,
                'activo'      => false,
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
        ]);
    }

    public function down(): void
    {
        // Revertir nombres de posición
        DB::table('mantenimiento_imagenes')
            ->where('posicion', 'izquierda_1')
            ->update(['posicion' => 'izquierda']);

        DB::table('mantenimiento_imagenes')
            ->where('posicion', 'derecha_1')
            ->update(['posicion' => 'derecha_superior']);

        DB::table('mantenimiento_imagenes')
            ->where('posicion', 'derecha_2')
            ->update(['posicion' => 'derecha_inferior']);

        // Borrar slots nuevos y configs
        DB::table('mantenimiento_imagenes')
            ->whereIn('posicion', [
                'izquierda_2', 'izquierda_3',
                'derecha_3',
                'config_layout_izq', 'config_layout_der',
            ])->delete();
    }
};