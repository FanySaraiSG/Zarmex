<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('mantenimiento_imagenes', function (Blueprint $table) {

            $table->string('lado')
                ->default('izquierda')
                ->after('ruta_imagen');

            $table->string('tamano')
                ->default('mediano')
                ->after('lado');

            $table->integer('orden')
                ->default(1)
                ->after('tamano');

            $table->boolean('activo')
                ->default(true)
                ->after('orden');

        });
    }

    public function down(): void
    {
        Schema::table('mantenimiento_imagenes', function (Blueprint $table) {

            $table->dropColumn([
                'lado',
                'tamano',
                'orden',
                'activo'
            ]);

        });
    }
};