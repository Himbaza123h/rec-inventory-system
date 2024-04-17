<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('purchases', function (Blueprint $table) {
            $table->id();
            $table->string('purchase_number');
            $table->string('product_brand');
            $table->string('product_code')->nullable();
            $table->string('product_color')->nullable();
            $table->string('product_attributes')->nullable();
            $table->string('product_power')->nullable();
            $table->string('quantity');
            $table->string('supplier')->nullable();
            $table->string('payment_method')->nullable();
            $table->string('total_price');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchases');
    }
};
