<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddProductIdToOrderItemsTable extends Migration
{
    public function up()
    {
        Schema::table('order_items', function (Blueprint $table) {
            // Thêm cột product_id, khóa ngoại tham chiếu tới products.id
            $table->foreignId('product_id')
                  ->nullable()            // Cho phép null để tránh vi phạm ràng buộc với dữ liệu cũ
                  ->after('order_id')
                  ->constrained()
                  ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('order_items', function (Blueprint $table) {
            $table->dropConstrainedForeignId('product_id');
        });
    }
}
