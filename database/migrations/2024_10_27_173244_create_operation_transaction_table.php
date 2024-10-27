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
        Schema::create('operation_transaction', function (Blueprint $table) {
            $table->unsignedBigInteger('operation_id');
            $table->unsignedBigInteger('transaction_id');
            $table->timestamps();

            $table->unique(['operation_id', 'transaction_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('operation_transaction');
    }
};
