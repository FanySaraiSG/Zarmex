<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('imagenes', function (Blueprint $table) {
            // Cambiar de ENUM a STRING
            $table->string('seccion', 60)->change();
        });
    }

    public function down(): void
    {
        Schema::table('imagenes', function (Blueprint $table) {
            // Opcional: si quisieras regresar a ENUM
            $table->enum('seccion', [
                'Logo',
                'Banner',
                'Nosotros Banner',
                'Nosotros (máx. 3 imágenes)'
            ])->change();
        });
    }
};