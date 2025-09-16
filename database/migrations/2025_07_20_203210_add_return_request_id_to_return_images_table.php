<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('return_images', function (Blueprint $table) {
            $table->foreignId('return_request_id')
                  ->after('id')
                  ->constrained('return_requests')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('return_images', function (Blueprint $table) {
            $table->dropForeign(['return_request_id']);
            $table->dropColumn('return_request_id');
        });
    }
};
