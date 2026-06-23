<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reparacion_imagenes', function (Blueprint $table) {
            $table->id();
            $table->string('posicion')->unique(); // izquierda_1, izquierda_2, izquierda_3, derecha_1, derecha_2, derecha_3
            $table->string('ruta_imagen');
            $table->boolean('activo')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reparacion_imagenes');
    }
};
