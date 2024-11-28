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
        Schema::create('lower_limits', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('user_id')->nullable();
            // $table->enum('type', ['roof', 'ceramic'])->nullable()->comment('kategori target batas bawah');
            $table->enum('category', ['dr-shield', 'dr-sonne'])->nullable()->comment('tipe target batas bawah');
            $table->integer('target_payment')->nullable()->comment('Target total dari pembayaran faktur');
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
        Schema::dropIfExists('lower_limits');
    }
};
