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
        Schema::create('schedule_deliveries', function (Blueprint $table) {
            $table->id();
            $table->integer('province_id')->nullable();
            $table->integer('district_id')->nullable();
            $table->integer('city_id')->nullable();
            $table->integer('outlet_id')->nullable();
            $table->string('schedule_no')->nullable();
            $table->string('status')->nullable();
            $table->date('date')->nullable();
            $table->date('scheduled_date')->nullable();
            $table->date('recieved_date')->nullable();
            $table->decimal('no_of_item',13,2)->default('0.00');
            $table->decimal('no_of_qty',13,2)->default('0.00');
            $table->decimal('amount',13,2)->default('0.00');
            $table->integer('user_id')->nullable();
            $table->integer('dispatched_by')->nullable();
            $table->integer('recieved_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schedule_deliveries');
    }
};
