<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('flash_sales', function (Blueprint $table) {
        $table->id();
        $table->decimal('discount_percent', 5, 2)->nullable();
        $table->decimal('discount_amount', 10, 2)->nullable();
        $table->dateTime('start_time');
        $table->dateTime('end_time');
        $table->timestamps(); // created_at, updated_at
    });
    }

    public function down(): void
    {
        Schema::dropIfExists('flash_sales');
    }
};
