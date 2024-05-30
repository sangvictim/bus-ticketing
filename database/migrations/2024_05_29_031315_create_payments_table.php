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
        Schema::create('payments', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->string('external_id')->unique();
            $table->foreignUlid('user_id')->references('id')->on('users');
            $table->foreignUlid('transaction_id')->references('id')->on('transactions');
            $table->string('channel');
            $table->string('code');
            $table->string('name');
            $table->string('account_number');
            $table->string('status');
            $table->double('expected_amount');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
