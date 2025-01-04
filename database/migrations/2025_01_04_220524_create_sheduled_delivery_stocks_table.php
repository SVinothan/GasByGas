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
        Schema::create('sheduled_delivery_stocks', function (Blueprint $table) {
            $table->id();
            $table->integer('province_id')->nullable();
            $table->integer('district_id')->nullable();
            $table->integer('city_id')->nullable();
            $table->integer('outlet_id')->nullable();
            $table->integer('qty')->nullable();
            $table->integer('cylinder_type_id')->nullable();
            $table->date('sheduled_date')->nullable();
            $table->string('status')->nullable();
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
        Schema::dropIfExists('sheduled_delivery_stocks');
    }
};
