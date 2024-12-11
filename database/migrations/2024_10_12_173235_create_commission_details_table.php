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
        Schema::create('commission_details', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('commission_id')->nullable();
            $table->integer('year')->nullable()->comment('Tahun komisi');
            $table->integer('month')->nullable()->comment('Bulan komisi');
            $table->integer('percentage_of_due_date')->nullable()->comment('persentase dari target');
            $table->double('total_income')->nullable()->comment('Total pendapatan yang masuk dari faktur setelah di bagi dengan 1,11');
            $table->integer('value_of_due_date')->nullable()->comment('nilai komisi untuk keramik');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('commission_details');
    }
};
