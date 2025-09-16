<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('flash_sales', function (Blueprint $table) {
            // Bước 1: Thêm cột mới
            $table->enum('applies_to', ['all', 'category', 'product'])->default('all')->after('end_time');
        });

        // Bước 2: Cập nhật dữ liệu từ scope sang applies_to (phải đặt bên ngoài closure)
        DB::statement("UPDATE flash_sales SET applies_to = scope");

        // Bước 3: Xoá cột cũ
        Schema::table('flash_sales', function (Blueprint $table) {
            $table->dropColumn('scope');
        });
    }

    public function down(): void
    {
        Schema::table('flash_sales', function (Blueprint $table) {
            $table->enum('scope', ['all', 'category', 'product'])->default('all')->after('end_time');
        });

        DB::statement("UPDATE flash_sales SET scope = applies_to");

        Schema::table('flash_sales', function (Blueprint $table) {
            $table->dropColumn('applies_to');
        });
    }
};

