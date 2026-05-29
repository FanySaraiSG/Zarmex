<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('imagenes_productos', function (Blueprint $table) {
            $table->string('id')->primary(); // Como tu ID es un string no autoincremental
            $table->string('producto_id');   // ID del producto relacionado
            $table->string('ruta');          // Ruta de la imagen
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('imagenes_productos');
    }
};