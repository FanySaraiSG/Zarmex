<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Agrega la columna 'orden' a la tabla top_products.
     * Si la tabla aún no existe, no hace falta esta migración
     * (ya estará en la migración original).
     */
    public function up(): void
{
    if (Schema::hasTable('top_products') && !Schema::hasColumn('top_products', 'orden')) {
        Schema::table('top_products', function (Blueprint $table) {
            $table->integer('orden')->default(0)->after('id');
        });
    }
}

    public function down(): void
    {
        Schema::table('top_products', function (Blueprint $table) {
            if (Schema::hasColumn('top_products', 'orden')) {
                $table->dropColumn('orden');
            }
        });
    }
};
