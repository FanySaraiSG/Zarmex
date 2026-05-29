<?php
// archivo: database/migrations/2025_XX_XX_add_orden_to_imagenes_productos.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('imagenes_productos', function (Blueprint $table) {
            // Solo lo agrega si no existe, para evitar errores al re-correr
            if (!Schema::hasColumn('imagenes_productos', 'orden')) {
                $table->unsignedInteger('orden')->default(0)->after('ruta');
            }
        });
    }

    public function down(): void
    {
        Schema::table('imagenes_productos', function (Blueprint $table) {
            $table->dropColumn('orden');
        });
    }
};