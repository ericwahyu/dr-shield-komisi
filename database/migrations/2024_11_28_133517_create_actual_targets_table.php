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
        Schema::create('actual_targets', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->enum('type', ['ceramic', 'roof'])->nullable()->comment('tipe');
            $table->enum('category', ['dr-shield', 'dr-sonne'])->nullable()->comment('kategori');
            $table->bigInteger('target')->nullable()->comment('target komisi dalam bertuk nominal uang');
            $table->integer('actual')->nullable()->comment('target komisi dalam bentuk persentase');
            $table->bigInteger('value_commission')->nullable()->comment('nominal komisi dalam bentuk nominal uang');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('actual_targets');
    }
};
