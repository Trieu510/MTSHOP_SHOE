<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('shipping_fees', function (Blueprint $table) {
            $table->id();
            $table->string('province')->unique();
            $table->unsignedInteger('fee');
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('shipping_fees');
    }
};
