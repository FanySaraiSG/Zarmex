<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up()
{
    Schema::table('reviews', function (Blueprint $table) {
        // Cambia producto_id a VARCHAR(50)
        $table->string('producto_id', 50)->change();
    });
}

public function down()
{
    Schema::table('reviews', function (Blueprint $table) {
        $table->unsignedBigInteger('producto_id')->change();
    });
}
};
