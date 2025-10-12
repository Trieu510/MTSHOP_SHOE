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
        Schema::table('messages', function (Blueprint $table) {
            // ➕ Thêm cột receiver_id để lưu ID người nhận tin nhắn
            $table->unsignedBigInteger('receiver_id')->after('user_id')->nullable();

            // (Tuỳ chọn) Nếu có bảng users, thêm ràng buộc khóa ngoại:
            $table->foreign('receiver_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('messages', function (Blueprint $table) {
            // Xoá khóa ngoại và cột khi rollback
            $table->dropForeign(['receiver_id']);
            $table->dropColumn('receiver_id');
        });
    }
};
