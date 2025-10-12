<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('coupons', function (Blueprint $table) {
            $table->boolean('is_spin_prize')->default(false)->after('is_active'); // có dùng cho vòng quay không
            $table->unsignedTinyInteger('chance')->default(0)->after('is_spin_prize'); // xác suất %
        });
    }

    public function down(): void
    {
        Schema::table('coupons', function (Blueprint $table) {
            $table->dropColumn(['is_spin_prize', 'chance']);
        });
    }
};
