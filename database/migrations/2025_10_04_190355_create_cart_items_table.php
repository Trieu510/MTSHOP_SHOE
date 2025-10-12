<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cart_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable(); // cho phép null (khách chưa login)
            $table->unsignedBigInteger('product_variant_id');
            $table->integer('quantity')->default(1);

            $table->timestamps();

            // Khóa ngoại
            $table->foreign('user_id')
                  ->references('id')->on('users')
                  ->onDelete('cascade');

            $table->foreign('product_variant_id')
                  ->references('id')->on('product_variants')
                  ->onDelete('cascade');

            // Một user chỉ có 1 cart_item cho mỗi variant
            $table->unique(['user_id', 'product_variant_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cart_items');
    }
};
