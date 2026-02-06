<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateColorsTable extends Migration
{
    public function up()
    {
        Schema::create('colors', function (Blueprint $table) {
            $table->string('id_color')->primary(); // ID del color en tipo varchar (formato Hex)
            $table->string('nombre'); // Nombre del color
            $table->timestamps(); // Campos created_at y updated_at
        });
    }

    public function down()
    {
        Schema::dropIfExists('colors');
    }
}
