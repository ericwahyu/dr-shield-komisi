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
        Schema::create('invoices', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('user_id');
            $table->enum('type', ['roof', 'ceramic'])->nullable()->comment('Jenis invoice atap atau keramik');
            $table->date('date')->nullable();
            $table->string('invoice_number')->nullable()->comment('nomor customer');
            $table->string('id_customer')->nullable()->comment('nomor id customer');
            $table->string('customer')->nullable()->comment('nama customer');
            $table->bigInteger('income_tax')->nullable()->comment('nominal DPP'); //DPP
            $table->bigInteger('value_tax')->nullable()->comment('nominal PPN'); //PPN
            $table->bigInteger('amount')->nullable()->comment('DPP + PPN'); //DPP + PPN
            $table->bigInteger('due_date')->nullable()->comment('Masa jatuh tempo untuk invoice atap');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
