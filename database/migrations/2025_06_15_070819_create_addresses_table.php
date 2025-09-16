<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('addresses', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        $table->string('label')->nullable();      // ví dụ: "Nhà riêng", "Cơ quan"
        $table->string('recipient_name');         // tên người nhận
        $table->string('phone');                  // điện thoại người nhận
        $table->string('province');               // tỉnh/thành
        $table->string('district');               // quận/huyện
        $table->string('ward');                   // phường/xã
        $table->text('detail');                   // địa chỉ chi tiết
        $table->boolean('is_default')->default(false);
        $table->timestamps();
    });
}
public function down()
{
    Schema::dropIfExists('addresses');
}

};
