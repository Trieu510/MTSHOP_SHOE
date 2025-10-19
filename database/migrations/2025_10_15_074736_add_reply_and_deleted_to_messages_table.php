<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('messages', function (Blueprint $table) {
            // 🔹 Cột để lưu ID tin nhắn được trả lời (nếu có)
            $table->unsignedBigInteger('reply_to_id')->nullable()->after('receiver_id')->index();

            // 🔹 Đánh dấu tin nhắn đã bị thu hồi / xóa
            $table->boolean('is_deleted')->default(false)->after('is_read');

            // 🔹 Lưu thời gian thu hồi (nếu có)
            $table->timestamp('deleted_at')->nullable()->after('is_deleted');
        });
    }

    public function down(): void
    {
        Schema::table('messages', function (Blueprint $table) {
            $table->dropColumn(['reply_to_id', 'is_deleted', 'deleted_at']);
        });
    }
};
