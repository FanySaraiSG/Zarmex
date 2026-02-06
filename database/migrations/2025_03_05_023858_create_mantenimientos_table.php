<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('mantenimientos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('ocupacion');
            $table->string('tipo_maquina');
            $table->string('codigo_equipo');
            $table->text('descripcion');
            $table->string('direccion');
            $table->string('estado');
            $table->string('codigo_postal');
            $table->string('correo_electronico')->nullable();
            $table->string('numero_celular')->nullable();
            // Definir 'status' correctamente como ENUM, sin 'after'
            $table->enum('status', ['En revisión', 'En procedimiento', 'En camino', 'Finalizado'])
                ->default('En revisión');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mantenimientos');
    }
};
