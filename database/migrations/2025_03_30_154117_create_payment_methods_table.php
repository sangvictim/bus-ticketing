<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Virtual accounts, Retail Outlets (OTC),eWallets,Kartu,QR Codes,Paylater
     */
    public function up(): void
    {
        Schema::create('payment_methods', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->integer('parent')->nullable();
            $table->string('icon')->nullable();
            $table->string('name');
            $table->string('code');
            $table->string('country');
            $table->string('currency');
            $table->boolean('isActivated')->default(true);
            $table->integer('sort')->nullable();
            $table->timestampsTz();
            $table->softDeletesTz();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_methods');
    }
};
