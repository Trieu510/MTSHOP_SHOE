<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('return_images', function (Blueprint $table) {
            $table->string('path')->after('return_request_id')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('return_images', function (Blueprint $table) {
            $table->dropColumn('path');
        });
    }
};
