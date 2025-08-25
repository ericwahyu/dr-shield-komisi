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
        Schema::create('data_resets', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('user_id')->nullable()->comment('User yang melakukan reset data');
            $table->string('data_reset')->nullable()->comment('tanggal import yang di reset');
            $table->string('date_reset')->nullable()->comment('tanggal dilakukannya reset');
            $table->string('note')->nullable()->comment('catatan');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_resets');
    }
};
