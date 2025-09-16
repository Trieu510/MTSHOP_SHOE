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
    Schema::table('posts', function (Blueprint $table) {
        $table->dropForeign(['category_id']);
        $table->dropColumn('category_id');

        $table->foreignId('post_category_id')->nullable()->constrained('post_categories')->nullOnDelete();
    });
}

public function down(): void
{
    Schema::table('posts', function (Blueprint $table) {
        $table->dropForeign(['post_category_id']);
        $table->dropColumn('post_category_id');

        $table->foreignId('category_id')->nullable()->constrained()->nullOnDelete();
    });
}

};
