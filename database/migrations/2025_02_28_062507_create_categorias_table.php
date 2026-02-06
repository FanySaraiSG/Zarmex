<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('categorias', function (Blueprint $table) {
            $table->string('id_categoria', 36)->primary();
            $table->string('nombre', 100);
            $table->text('descripcion')->nullable();
            $table->timestamp('creado_en')->useCurrent();
            $table->timestamp('actualizado_en')->useCurrent()->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('categorias');
    }
};
