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
            // 📝 Thêm cột 'type' để phân biệt loại tin nhắn (text, image, file)
            $table->string('type')->default('text')->after('content');

            // 📝 Thêm cột 'file_path' để lưu đường dẫn file upload
            $table->string('file_path')->nullable()->after('type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('messages', function (Blueprint $table) {
            $table->dropColumn(['type', 'file_path']);
        });
    }
};
