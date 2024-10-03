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
        Schema::create('invoice_details', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('invoice_id');
            $table->enum('type', ['dr-shield', 'dr-sonne', 'ceramic'])->nullable()->comment('Jenis invoice dr.shield, dr.sonne, atau keramik');
            $table->bigInteger('amount')->nullable()->comment('nominal pembayaran');
            $table->timestamp('date')->nullable()->comment('tanggal pemabayaran');
            $table->bigInteger('percentage')->nullable()->comment('persentage nominal yang masuk ke sales');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoice_details');
    }
};
