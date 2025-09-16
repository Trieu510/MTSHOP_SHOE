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
        Schema::create('wishlists', function (Blueprint $table) {
            $table->id();

            // Khóa ngoại tới users.id
            $table->foreignId('user_id')
                  ->constrained()
                  ->onDelete('cascade');

            // Khóa ngoại tới products.id
            $table->foreignId('product_id')
                  ->constrained()
                  ->onDelete('cascade');

            $table->timestamps();

            // Mỗi user chỉ có thể thêm 1 lần 1 sản phẩm vào wishlist
            $table->unique(['user_id', 'product_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wishlists');
    }
};
