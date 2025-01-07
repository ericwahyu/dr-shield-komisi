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
            $table->foreignUuid('category_id')->nullable()->comment('kategori');
            $table->integer('version')->nullable()->comment('versi komisi');
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
