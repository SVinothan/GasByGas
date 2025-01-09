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
        Schema::create('stocks', function (Blueprint $table) {
            $table->id();
            $table->integer('province_id')->nullable();
            $table->integer('district_id')->nullable();
            $table->integer('city_id')->nullable();
            $table->integer('outlet_id')->nullable();
            $table->integer('sheduled_delivery_id')->nullable();
            $table->integer('qty')->nullable();
            $table->integer('item_id')->nullable();
            $table->date('stock_date')->nullable();
            $table->string('batch_no')->nullable();
            $table->decimal('cost_price',13,2)->default('0.00');
            $table->decimal('sales_price',13,2)->default('0.00');
            $table->integer('user_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stocks');
    }
};
