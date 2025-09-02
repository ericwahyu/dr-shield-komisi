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
        Schema::create('percentage_region_commissions', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->enum('type', ['roof', 'ceramic'])->nullable()->comment('kode atap atau keramik');
            $table->integer('percentage_target')->nullable()->comment('nilai persentase');
            $table->decimal('percentage_commission')->nullable()->comment('nilai persentase komisinya');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('percentage_region_commissions');
    }
};
