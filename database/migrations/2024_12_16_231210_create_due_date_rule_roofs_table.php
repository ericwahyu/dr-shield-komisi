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
        Schema::create('due_date_rule_roofs', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->enum('type', ['roof', 'ceramic'])->nullable()->default('ceramic')->comment('tipe jatuh tempo');
            $table->integer('version')->nullable()->comment('versi komisi');
            $table->integer('due_date')->nullable()->comment('diffDays');
            $table->integer('value')->nullable()->comment('nilai format %');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('due_date_rule_roofs');
    }
};
