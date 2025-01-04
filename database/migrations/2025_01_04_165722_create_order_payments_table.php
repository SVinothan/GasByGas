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
        Schema::create('order_payments', function (Blueprint $table) {
            $table->id();
            $table->integer('province_id')->nullable();
            $table->integer('district_id')->nullable();
            $table->integer('city_id')->nullable();
            $table->integer('outlet_id')->nullable();
            $table->integer('customer_id')->nullable();
            $table->integer('customer_order_id')->nullable();
            $table->integer('customer_order_delivery_id')->nullable();
            $table->integer('no_of_cylinder')->nullable();
            $table->integer('cylinder_type_id')->nullable();
            $table->decimal('amount',13,2)->default('0.00');
            $table->decimal('total',13,2)->default('0.00');
            $table->date('payment_date')->nullable();
            $table->string('payment_mode')->nullable();
            $table->integer('user_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_payments');
    }
};
