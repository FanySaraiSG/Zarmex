<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('top_products', function (Blueprint $table) {
            $table->id();
            $table->string('product_id', 15)->nullable();
            $table->timestamps();

            $table->foreign('product_id')->references('id')->on('productos')->nullOnDelete();
        });
    }

    public function down(): void {
        Schema::dropIfExists('top_products');
    }
};
