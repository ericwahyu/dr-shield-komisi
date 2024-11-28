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
        Schema::create('due_date_rules', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('invoice_id')->nullable();
            $table->enum('type', ['roof', 'ceramic'])->nullable()->comment('tipe jatuh tempo');
            $table->integer('number')->nullable()->comment('urutan aturan jatuh tempo (1,2,3,..)');
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
        Schema::dropIfExists('due_date_rules');
    }
};
