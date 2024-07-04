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
        Schema::create('transactions', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid('user_id')->constrained('users');
            $table->string('transaction_code')->unique()->index();
            $table->unsignedBigInteger('payment_method')->nullable()->references('id')->on('payment_methods');
            $table->string('status'); // cancel, booking, paid
            $table->double('total_amount');
            $table->foreignId('origin_city')->references('id')->on('cities');
            $table->foreignId('destination_city')->references('id')->on('cities');
            $table->dateTimeTz('departure')->nullable();
            $table->dateTimeTz('checkin')->nullable();
            $table->dateTimeTz('checkout')->nullable();
            $table->timestampsTz();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
