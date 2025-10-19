<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('messages', function (Blueprint $table) {
            // ✅ Chỉ thêm cột nếu chưa tồn tại
            if (!Schema::hasColumn('messages', 'receiver_id')) {
                $table->unsignedBigInteger('receiver_id')->after('user_id')->nullable();
                $table->foreign('receiver_id')->references('id')->on('users')->onDelete('cascade');
            }
        });
    }

    public function down(): void
    {
        Schema::table('messages', function (Blueprint $table) {
            if (Schema::hasColumn('messages', 'receiver_id')) {
                $table->dropForeign(['receiver_id']);
                $table->dropColumn('receiver_id');
            }
        });
    }
};
