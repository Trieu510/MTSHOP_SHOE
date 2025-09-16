<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('return_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->onDelete('cascade'); // liên kết đơn hàng
            $table->foreignId('user_id')->constrained()->onDelete('cascade');  // người gửi yêu cầu
            $table->text('reason'); // lý do hoàn trả
            $table->enum('status', ['pending', 'accepted', 'rejected', 'exchanged'])->default('pending'); // trạng thái
            $table->timestamps(); // created_at & updated_at
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('return_requests');
    }
};
