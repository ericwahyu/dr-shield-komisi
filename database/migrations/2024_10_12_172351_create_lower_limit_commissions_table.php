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
        Schema::create('lower_limit_commissions', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('commission_id')->nullable();
            $table->foreignUuid('lower_limit_id')->nullable();
            // $table->enum('type', ['dr-shield', 'dr-sonne'])->nullable()->comment('tipe target batas bawah');
            $table->foreignUuid('category_id')->nullable()->comment('kategori');
            $table->bigInteger('target_payment')->nullable()->comment('Target total dari pembayaran faktur');
            $table->double('value')->nullable()->comment('nilai format %');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lower_limit_commissions');
    }
};
