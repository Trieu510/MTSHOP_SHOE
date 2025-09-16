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
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique(); // Mã giảm giá
            $table->enum('type', ['fixed', 'percent']); // Kiểu giảm: cố định hoặc phần trăm
            $table->decimal('value', 10, 2); // Giá trị giảm
            $table->decimal('min_order_amount', 10, 2)->nullable(); // Điều kiện: đơn hàng tối thiểu
            $table->integer('usage_limit')->nullable(); // Số lần sử dụng tối đa
            $table->integer('used')->default(0); // Đã dùng bao nhiêu lần
            $table->dateTime('expires_at')->nullable(); // Ngày hết hạn
            $table->boolean('is_active')->default(true); // Trạng thái hoạt động
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coupons');
    }
};
