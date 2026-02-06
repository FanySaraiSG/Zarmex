<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('medidas', function (Blueprint $table) {
            $table->id();
            $table->string('producto_id'); // Relación con productos
            $table->decimal('largo', 8, 2);
            $table->decimal('ancho', 8, 2);
            $table->decimal('altura', 8, 2);
            $table->timestamps();

            $table->foreign('producto_id')->references('id')->on('productos')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('medidas');
    }
};
