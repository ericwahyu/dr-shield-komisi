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
        Schema::create('commissions', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('user_id')->nullable();
            $table->foreignUuid('actual_target_id')->nullable();
            $table->integer('year')->nullable()->comment('Tahun komisi');
            $table->integer('month')->nullable()->comment('Bulan komisi');
            // $table->enum('category', ['dr-shield', 'dr-sonne'])->nullable()->comment('tipe komisi');
            $table->foreignUuid('category_id')->nullable()->comment('kategori');
            $table->bigInteger('total_sales')->nullable()->comment('Total Penjualan dari total DPP');
            $table->double('percentage_value_commission')->nullable()->comment('nilai komisi persen yang didapatkan dari target');
            $table->bigInteger('value_commission')->nullable()->comment('Nilai komisi');
            $table->bigInteger('add_on_commission')->nullable()->comment('Nilai Tambahan komisi');
            $table->enum('status', ['not-reach', 'reached'])->default('not-reach')->nullable()->comment('status komisi : mencapai target atau tidak');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('commissions');
    }
};
