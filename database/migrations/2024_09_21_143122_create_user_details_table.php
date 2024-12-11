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
        Schema::create('user_details', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('user_id');
            $table->string('civil_registration_number')->nullable()->comment('nomor KTP');
            $table->string('depo')->nullable()->comment('Kode DEPO');
            $table->enum('sales_type', ['roof', 'ceramic'])->nullable()->comment('kode sales, atap atau keramik');
            $table->string('sales_code')->nullable()->comment('Kode Sales');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_details');
    }
};
