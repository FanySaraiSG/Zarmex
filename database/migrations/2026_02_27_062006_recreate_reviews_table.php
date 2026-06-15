<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::dropIfExists('reviews');

    Schema::create('reviews', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('producto_id');
        $table->string('guest_nombre', 60)->nullable();
        $table->string('guest_email', 120)->nullable(); 
        $table->unsignedTinyInteger('calificacion'); // 1-5
        $table->text('descripcion');
        $table->enum('estatus', ['pendiente', 'aprobado', 'oculto'])->default('pendiente');
        $table->string('ip', 45)->nullable();
        $table->timestamps();

        $table->index('producto_id');
        // FK (actívalo si productos.id existe y coincide tipo)
        // $table->foreign('producto_id')->references('id')->on('productos')->onDelete('cascade');
    });
}

public function down()
{
    Schema::dropIfExists('reviews');
}
};
