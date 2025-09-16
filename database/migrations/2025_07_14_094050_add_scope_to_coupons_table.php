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
         Schema::table('coupons', function (Blueprint $table) {
        $table->enum('scope', ['all', 'category', 'product'])->default('all');
        $table->unsignedBigInteger('category_id')->nullable()->after('scope');
        $table->unsignedBigInteger('product_id')->nullable()->after('category_id');

        $table->foreign('category_id')->references('id')->on('categories')->onDelete('set null');
        $table->foreign('product_id')->references('id')->on('products')->onDelete('set null');
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('coupons', function (Blueprint $table) {
        $table->dropForeign(['category_id']);
        $table->dropForeign(['product_id']);
        $table->dropColumn(['scope', 'category_id', 'product_id']);
    });
    }
};
