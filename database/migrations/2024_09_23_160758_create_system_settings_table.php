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
        Schema::create('system_settings', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->double('value_of_total_income')->nullable()->comment('perkalian dari untuk total pendapatan');
            $table->double('value_incentive')->nullable()->comment('persentase tambahan untuk komisi keramik jika lebih dari target baling bawah');
            $table->string('sudo_password')->nullable()->comment('sudo password auth');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('system_settings');
    }
};
