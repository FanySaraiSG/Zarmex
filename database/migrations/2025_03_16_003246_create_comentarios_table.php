<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('comentarios', function (Blueprint $table) {
            $table->id();
            $table->string('producto_id', 15); // Referencia a productos.id
            $table->unsignedBigInteger('user_id'); // Referencia a users.id
            $table->tinyInteger('calificacion')->unsigned();
            $table->text('comentario');
            $table->timestamps();

            // Claves foráneas
            $table->foreign('producto_id')->references('id')->on('productos')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('comentarios');
    }
};
