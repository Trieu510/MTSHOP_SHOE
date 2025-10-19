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
            // 🧩 Tin nhắn bị thu hồi
            $table->boolean('is_recalled')->default(false)->after('is_deleted');

            // 🧩 Xóa một phía (người gửi hoặc người nhận)
            $table->boolean('deleted_by_sender')->default(false)->after('is_recalled');
            $table->boolean('deleted_by_receiver')->default(false)->after('deleted_by_sender');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('messages', function (Blueprint $table) {
            $table->dropColumn(['is_recalled', 'deleted_by_sender', 'deleted_by_receiver']);
        });
    }
};
