<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("ALTER TABLE imagenes MODIFY COLUMN seccion VARCHAR(60) NOT NULL");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE imagenes MODIFY COLUMN seccion ENUM('Logo','Banner','Nosotros Banner','Nosotros (máx. 3 imágenes)') NOT NULL");
    }
};