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
        // Change invoices table
        Schema::table('invoices', function (Blueprint $table) {
            $table->decimal('income_tax', 20, 2)->nullable()->comment('nominal DPP')->change();
            $table->decimal('value_tax', 20, 2)->nullable()->comment('nominal PPN')->change();
            $table->decimal('amount', 20, 2)->nullable()->comment('DPP + PPN')->change();
        });

        // Change invoice_details table
        Schema::table('invoice_details', function (Blueprint $table) {
            $table->decimal('amount', 20, 2)->nullable()->comment('nominal pembayaran')->change();
            $table->decimal('percentage', 20, 2)->nullable()->comment('persentage nominal yang masuk ke sales')->change();
        });

        // Change payment_details table
        Schema::table('payment_details', function (Blueprint $table) {
            $table->decimal('income_tax', 20, 2)->nullable()->comment('nominal DPP')->change();
            $table->decimal('value_tax', 20, 2)->nullable()->comment('nominal PPN')->change();
            $table->decimal('amount', 20, 2)->nullable()->comment('DPP + PPN')->change();
        });

        // Change commissions table
        Schema::table('commissions', function (Blueprint $table) {
            $table->decimal('total_sales', 20, 2)->nullable()->comment('Total Penjualan dari total DPP')->change();
            $table->decimal('value_commission', 20, 2)->nullable()->comment('Nilai komisi')->change();
            $table->decimal('add_on_commission', 20, 2)->nullable()->comment('Nilai Tambahan komisi')->change();
        });

        // Change commission_details table
        Schema::table('commission_details', function (Blueprint $table) {
            $table->decimal('value_of_due_date', 20, 2)->nullable()->comment('nilai komisi untuk keramik')->change();
            $table->decimal('percentage_of_due_date', 10, 2)->nullable()->comment('persentase dari target')->change();
        });

        // Change lower_limit_commissions table
        Schema::table('lower_limit_commissions', function (Blueprint $table) {
            $table->decimal('target_payment', 20, 2)->nullable()->comment('Target total dari pembayaran faktur')->change();
        });

        // Change region_commissions table
        Schema::table('region_commissions', function (Blueprint $table) {
            $table->decimal('total_income_tax', 20, 2)->nullable()->change();
            $table->decimal('value_commission', 20, 2)->nullable()->comment('Nilai komisi')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert invoices table
        Schema::table('invoices', function (Blueprint $table) {
            $table->bigInteger('income_tax')->nullable()->comment('nominal DPP')->change();
            $table->bigInteger('value_tax')->nullable()->comment('nominal PPN')->change();
            $table->bigInteger('amount')->nullable()->comment('DPP + PPN')->change();
        });

        // Revert invoice_details table
        Schema::table('invoice_details', function (Blueprint $table) {
            $table->bigInteger('amount')->nullable()->comment('nominal pembayaran')->change();
            $table->bigInteger('percentage')->nullable()->comment('persentage nominal yang masuk ke sales')->change();
        });

        // Revert payment_details table
        Schema::table('payment_details', function (Blueprint $table) {
            $table->bigInteger('income_tax')->nullable()->comment('nominal DPP')->change();
            $table->bigInteger('value_tax')->nullable()->comment('nominal PPN')->change();
            $table->bigInteger('amount')->nullable()->comment('DPP + PPN')->change();
        });

        // Revert commissions table
        Schema::table('commissions', function (Blueprint $table) {
            $table->bigInteger('total_sales')->nullable()->comment('Total Penjualan dari total DPP')->change();
            $table->bigInteger('value_commission')->nullable()->comment('Nilai komisi')->change();
            $table->bigInteger('add_on_commission')->nullable()->comment('Nilai Tambahan komisi')->change();
        });

        // Revert commission_details table
        Schema::table('commission_details', function (Blueprint $table) {
            $table->bigInteger('value_of_due_date')->nullable()->comment('nilai komisi untuk keramik')->change();
            $table->integer('percentage_of_due_date')->nullable()->comment('persentase dari target')->change();
        });

        // Revert lower_limit_commissions table
        Schema::table('lower_limit_commissions', function (Blueprint $table) {
            $table->bigInteger('target_payment')->nullable()->comment('Target total dari pembayaran faktur')->change();
        });

        // Revert region_commissions table
        Schema::table('region_commissions', function (Blueprint $table) {
            $table->bigInteger('total_income_tax')->nullable()->change();
            $table->bigInteger('value_commission')->nullable()->comment('Nilai komisi')->change();
        });
    }
};
