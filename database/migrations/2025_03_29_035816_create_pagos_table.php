<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('pagos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('direccion_id');
            $table->foreign('direccion_id')->references('id_direccion')->on('direcciones')->onDelete('cascade');
            $table->string('metodo_pago');
            $table->decimal('monto_total', 10, 2);
            $table->string('estado')->default('pendiente');
            $table->string('transaccion_id')->nullable();
            $table->json('detalles')->nullable();
            $table->json('productos')->nullable();
            $table->string('estado_interno')->default('PENDIENTE'); // Agregar el nuevo campo aquí
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pagos');
    }
};