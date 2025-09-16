<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReviewsTable extends Migration
{
    public function up()
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            // Khóa ngoại tới products.id
            $table->foreignId('product_id')
                  ->constrained()
                  ->onDelete('cascade');
            // Khóa ngoại tới users.id
            $table->foreignId('user_id')
                  ->constrained()
                  ->onDelete('cascade');
            // Rating 1–5 sao
            $table->tinyInteger('rating')->unsigned();
            // Bình luận (có thể để trống)
            $table->text('comment')->nullable();
            $table->timestamps();

            // Mỗi user chỉ được đánh giá 1 lần cho mỗi sản phẩm
            $table->unique(['product_id', 'user_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('reviews');
    }
}
