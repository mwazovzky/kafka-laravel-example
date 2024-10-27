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
        Schema::create('addresses', function (Blueprint $table) {
            $table->id();
            $table->string('type', 20);
            $table->string('status', 20);
            $table->string('hash');
            $table->unsignedBigInteger('chain_id');
            $table->unsignedBigInteger('client_id');
            $table->timestamps();

            $table->foreign('chain_id')->references('id')->on('chains');
            $table->foreign('client_id')->references('id')->on('clients');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('addresses');
    }
};
