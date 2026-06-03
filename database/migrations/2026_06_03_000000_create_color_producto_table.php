<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('color_producto', function (Blueprint $table) {
            $table->id();
            $table->string('producto_id');
            $table->string('color_id');
            $table->timestamps();

            $table->foreign('producto_id')
                  ->references('id')
                  ->on('productos')
                  ->onDelete('cascade');

            $table->foreign('color_id')
                  ->references('id_color')
                  ->on('colors')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('color_producto');
    }
};