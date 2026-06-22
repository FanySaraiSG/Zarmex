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
    { // <--- Llave de apertura de 'up'
        Schema::create('festividades', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');              
            $table->string('texto_header')->default('ZARMEX'); 
            $table->string('color_texto')->default('#b8a120');  
            $table->string('efecto')->default('none');  
            $table->json('decoraciones')->nullable();   
            $table->date('fecha_inicio')->nullable();
            $table->date('fecha_fin')->nullable();
            $table->boolean('activa')->default(false);  
            $table->timestamps();
        });
    } // <--- ESTA LLAVE TE FALTABA PARA CERRAR 'up'

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('festividades');
    }
};