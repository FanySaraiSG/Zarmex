<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('top_products', function (Blueprint $table) {
            if (!Schema::hasColumn('top_products', 'section')) {
                $table->string('section', 30)->default('todos')->after('product_id');
            }
        });
    }

    public function down(): void {
        Schema::table('top_products', function (Blueprint $table) {
            if (Schema::hasColumn('top_products', 'section')) {
                $table->dropColumn('section');
            }
        });
    }
};

