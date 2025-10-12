<?php

// database/migrations/xxxx_xx_xx_create_messages_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade'); // người gửi
            $table->foreignId('receiver_id')->nullable()->constrained('users')->onDelete('cascade'); // người nhận (admin)
            $table->text('content'); // nội dung tin nhắn
            $table->boolean('is_read')->default(false); // đã đọc hay chưa
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('messages');
    }
};
