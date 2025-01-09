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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->integer('province_id')->nullable();
            $table->integer('district_id')->nullable();
            $table->integer('city_id')->nullable();
            $table->string('full_name')->nullable();
            $table->text('address')->nullable();
            $table->string('email')->nullable();
            $table->integer('mobile_no')->nullable();
            $table->string('nic_no')->nullable();
            $table->string('type')->nullable();
            $table->string('bussiness_name')->nullable();
            $table->string('bussiness_reg_no')->nullable();
            $table->longText('bussiness_reg_document')->nullable();
            $table->string('status')->nullable();
            $table->date('status_date')->nullable();
            $table->integer('status_by')->nullable();
            $table->integer('cylinder_limit')->nullable();
            $table->integer('user_id')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
