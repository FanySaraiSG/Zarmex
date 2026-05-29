<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up(): void
    {
        Schema::create('videos_productos', function (Blueprint $table) {
            // Cambiamos a string el ID de la tabla de videos porque en el controlador usas un VID_...
            $table->string('id')->primary(); 
            
            // Creamos la columna para el ID del producto (como tus IDs tienen letras y guiones, debe ser string)
            $table->string('producto_id'); 
            
            // Creamos la columna para guardar el camino del archivo del video
            $table->string('ruta'); 
            
            $table->timestamps();

            // Opcional pero recomendado: llave foránea para que esté amarrado a tu tabla productos
            $table->foreign('producto_id')->references('id')->on('productos')->onDelete('cascade');
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('videos_productos');
    }
};
