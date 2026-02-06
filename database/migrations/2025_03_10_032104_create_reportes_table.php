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
        Schema::create('reportes', function (Blueprint $table) {
            $table->id('id_reporte');
            $table->unsignedBigInteger('id');
            $table->enum('tipo_reporte', ['soporte', 'queja'])->default('soporte');
            $table->text('descripcion');
            $table->enum('estado', ['pendiente', 'en proceso', 'resuelto'])->default('pendiente');
            $table->unsignedBigInteger('id_empleado')->nullable();
            $table->timestamp('creado_en')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('actualizado_en')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
            
            $table->foreign('id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('id_empleado')->references('id_empleado')->on('employees')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reportes');
    }
};
