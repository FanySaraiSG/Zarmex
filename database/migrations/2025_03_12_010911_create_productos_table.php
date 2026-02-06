<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('productos', function (Blueprint $table) {
            $table->string('id', 15)->primary(); // Aseguramos que el ID sea VARCHAR(15)
            $table->string('nombre');
            $table->text('descripcion')->nullable();
            $table->decimal('precio', 10, 2);
            $table->integer('stock');
            $table->string('categoria_id', 36); // Debe coincidir con la categoría
            $table->string('imagen_url')->nullable();
            $table->timestamp('fecha_creacion')->useCurrent(); // Fecha automática
            $table->foreign('categoria_id')->references('id_categoria')->on('categorias')->onDelete('cascade');
        });
    }


    public function down()
    {
        Schema::dropIfExists('productos');
    }
};
