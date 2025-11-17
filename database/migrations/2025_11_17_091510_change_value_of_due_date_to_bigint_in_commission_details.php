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
        Schema::table('commission_details', function (Blueprint $table) {
            // Ubah tipe data dari integer ke bigInteger untuk menampung nilai lebih besar
            $table->bigInteger('value_of_due_date')->nullable()->comment('nilai komisi untuk keramik')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('commission_details', function (Blueprint $table) {
            // Kembalikan ke integer jika rollback
            $table->integer('value_of_due_date')->nullable()->comment('nilai komisi untuk keramik')->change();
        });
    }
};
