<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('stock_logs', function (Blueprint $table) {
            $table->id();

            // Khóa ngoại đến biến thể sản phẩm
            $table->foreignId('product_variant_id')->constrained()->onDelete('cascade');

            // Loại log: nhập kho hoặc điều chỉnh
            $table->enum('type', ['import', 'adjust'])->default('import');

            // Số lượng nhập/thay đổi
            $table->integer('quantity');

            // Ghi chú thêm
            $table->text('note')->nullable();

            // Admin thực hiện (nullable trong trường hợp tự động)
            $table->foreignId('admin_id')->nullable()->constrained('users')->onDelete('set null');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stock_logs');
    }
};
