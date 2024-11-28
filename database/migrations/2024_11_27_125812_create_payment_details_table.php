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
        Schema::create('payment_details', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('invoice_id');
            $table->enum('category', ['dr-shield', 'dr-sonne'])->nullable()->comment('tipe detail pembayaran');
            $table->bigInteger('income_tax')->nullable()->comment('nominal DPP'); //DPP
            $table->bigInteger('value_tax')->nullable()->comment('nominal PPN'); //PPN
            $table->bigInteger('amount')->nullable()->comment('DPP + PPN'); //DPP + PPN
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_details');
    }
};
