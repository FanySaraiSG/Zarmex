<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateImagenesProductosTable extends Migration
{
    public function up()
    {
        Schema::create('imagenes_productos', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('producto_id', 15); // Cambiado a string(15)
            $table->string('ruta');
            $table->foreign('producto_id')->references('id')->on('productos')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('imagenes_productos');
    }
}