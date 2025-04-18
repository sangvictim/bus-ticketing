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
        Schema::create('prices', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid('route_id')->references('id')->on('routes');
            $table->foreignUlid('class_id')->references('id')->on('classes');
            $table->string('name');
            $table->string('price');
            $table->string('cut_of_price')->nullable();
            $table->string('discount')->nullable();
            $table->string('discount_type')->nullable();
            $table->dateTimeTz('start_date')->nullable();
            $table->dateTimeTz('end_date')->nullable();
            $table->timestampsTz();
            $table->softDeletesTz();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prices');
    }
};
