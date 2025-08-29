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
        Schema::create('region_commissions', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('user_id')->nullable()->comment('User yang melakukan generate');
            $table->string('month')->nullable()->comment('bulan komisi wilayah');
            $table->enum('sales_type', ['roof', 'ceramic'])->nullable()->comment('kode sales, atap atau keramik');
            $table->string('depo')->nullable()->comment('Kode DEPO');
            $table->jsonb('targets')->nullable()->comment('berisi multiple nilai target agar flexible');
            $table->bigInteger('total_income_tax')->nullable()->comment();
            $table->double('percentage_target')->nullable()->comment('persentase dari target');
            $table->double('percentage_commission')->nullable()->comment('persentase komisi');
            $table->jsonb('payments')->nullable()->comment('berisi multiple nilai dari persentase pembayaran');
            $table->bigInteger('value_commission')->nullable()->comment('Nilai komisi');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('region_commissions');
    }
};
