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
        Schema::create('reviews', function (Blueprint $table) {
            $table->id('id_reseña');
            $table->string('email');
            $table->text('descripcion');
            $table->tinyInteger('calificacion')->unsigned()->check('calificacion >= 1 AND calificacion <= 5');
            $table->enum('estatus', ['activo', 'inactivo'])->default('inactivo');
            $table->timestamps();

            // Clave foránea
            $table->foreign('email')->references('email')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
