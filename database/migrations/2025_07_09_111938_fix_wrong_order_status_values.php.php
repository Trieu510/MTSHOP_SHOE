<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void {
        DB::table('orders')->where('status', 'shipping')->update(['status' => 'processing']);
        DB::table('orders')->where('status', 'canceled')->update(['status' => 'cancelled']);
    }

    public function down(): void {
        DB::table('orders')->where('status', 'processing')->update(['status' => 'shipping']);
        DB::table('orders')->where('status', 'cancelled')->update(['status' => 'canceled']);
    }
};
