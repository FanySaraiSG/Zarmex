<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('imagenes', function (Blueprint $table) {
            $table->id();
            $table->string('nombre')->unique(); // 'logo', 'banner', etc.
            $table->string('imagen_url'); // Guardará la ruta completa
            $table->enum('seccion', ['banner', 'nosotros_banner', 'logo', 'nosotros']);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('imagenes');
    }
};

