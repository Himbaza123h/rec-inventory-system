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
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->string('product');
            $table->string('client');
            $table->string('brand');
            $table->string('item_code');
            $table->decimal('price', 10, 3);
            $table->decimal('discount', 10, 3)->default(0);
            $table->integer('qty');
            $table->string('color');
            $table->string('customer_name');
            $table->string('contact');
            $table->string('vat');
            $table->text('operation_notes');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales');
    }
};
