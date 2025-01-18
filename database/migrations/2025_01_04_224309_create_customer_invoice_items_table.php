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
        Schema::create('customer_invoice_items', function (Blueprint $table) {
            $table->id();
            $table->integer('province_id')->nullable();
            $table->integer('district_id')->nullable();
            $table->integer('city_id')->nullable();
            $table->integer('outlet_id')->nullable();
            $table->integer('customer_id')->nullable();
            $table->integer('customer_order_id')->nullable();
            $table->integer('customer_invoice_id')->nullable();
            $table->integer('order_date')->nullable();
            $table->integer('item_id')->nullable();
            $table->integer('stock_id')->nullable();
            $table->integer('schedule_delivery_id')->nullable();
            $table->integer('qty')->nullable();
            $table->decimal('amount',13,2)->default('0.00');
            $table->decimal('total',13,2)->default('0.00');
            $table->integer('user_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_invoice_items');
    }
};
