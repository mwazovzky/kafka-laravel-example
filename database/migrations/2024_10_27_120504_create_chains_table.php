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
        Schema::create('chains', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('chain_currency_id');
            $table->timestamps();

            $table->foreign('chain_currency_id')->references('id')->on('currencies');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chains');
    }
};
