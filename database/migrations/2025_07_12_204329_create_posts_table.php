<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('title');                        // Tiêu đề bài viết
            $table->string('slug')->unique();               // Slug SEO
            $table->text('excerpt')->nullable();            // Mô tả ngắn
            $table->longText('content');                    // Nội dung chính
            $table->string('thumbnail')->nullable();        // Ảnh đại diện
            $table->boolean('is_featured')->default(false); // Có hiển thị nổi bật không
            $table->foreignId('category_id')->nullable()->constrained()->nullOnDelete(); // Danh mục
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
