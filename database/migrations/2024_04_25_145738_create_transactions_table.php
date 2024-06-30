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
            $table->string('status'); // cancel, booking, paid
            $table->double('total_price');
            $table->double('price')->nullable();
            $table->double('discount')->nullable();
            $table->string('discount_type')->nullable();
            $table->foreignId('origin_city')->references('id')->on('cities');
            $table->foreignId('destination_city')->references('id')->on('cities');
            $table->string('armada_code');
            $table->string('armada_name');
            $table->string('armada_class');
            $table->string('armada_seat');
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
