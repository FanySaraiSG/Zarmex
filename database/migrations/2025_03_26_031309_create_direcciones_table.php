<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('direcciones', function (Blueprint $table) {
            $table->string('id_direccion')->primary();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('tipo'); // casa, trabajo, oficina
            $table->string('telefono', 20); // Permite lada internacional
            $table->string('pais');
            $table->string('estado');
            $table->string('ciudad');
            $table->string('codigo_postal')->nullable();
            $table->string('calle');
            $table->string('numero_exterior');
            $table->string('numero_interior')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('direcciones');
    }
};
