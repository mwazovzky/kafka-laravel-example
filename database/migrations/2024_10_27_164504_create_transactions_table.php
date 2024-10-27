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
            $table->id();
            $table->string('type', 20);
            $table->string('status', 20);
            $table->string('txid');
            $table->integer('vout');
            $table->unsignedBigInteger('address_id');
            $table->unsignedBigInteger('chain_id');
            $table->unsignedBigInteger('currency_id');
            $table->decimal('amount', 20, 8);
            $table->unsignedBigInteger('fee_currency_id')->nullable();
            $table->decimal('fee_amount', 20, 8)->nullable();
            $table->timestamps();

            $table->foreign('address_id')->references('id')->on('addresses');
            $table->foreign('chain_id')->references('id')->on('chains');
            $table->foreign('currency_id')->references('id')->on('currencies');
            $table->foreign('fee_currency_id')->references('id')->on('currencies');
            $table->unique(['chain_id', 'txid', 'vout']);
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
