<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCarritoTable extends Migration
{
    public function up()
    {
        Schema::create('carrito', function (Blueprint $table) {
            $table->id(); // ID auto-incremental
            $table->foreignId('id_usuario')->constrained('users')->onDelete('cascade'); // Relación con users
        
            $table->string('id_producto', 15); // Coincide con VARCHAR(15) de productos.id
            $table->foreign('id_producto')->references('id')->on('productos')->onDelete('cascade');
        
            $table->string('id_color'); // Asegura que coincida con VARCHAR de colors.id_color
            $table->foreign('id_color')->references('id_color')->on('colors')->onDelete('cascade');
        
            $table->integer('cantidad')->default(1);
            $table->decimal('precio', 8, 2);
            $table->timestamps();
        });
        
    }


    public function down()
    {
        Schema::table('carrito', function (Blueprint $table) {
            // Eliminar las claves foráneas antes de eliminar la tabla
            $table->dropForeign(['id_usuario']);
            $table->dropForeign(['id_producto']);
            $table->dropForeign(['id_color']);
        });

        Schema::dropIfExists('carrito'); // Eliminar la tabla carrito
    }
}
