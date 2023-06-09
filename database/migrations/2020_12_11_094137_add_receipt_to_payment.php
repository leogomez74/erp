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
        Schema::table('payments', function (Blueprint $table) {
            $table->string('add_receipt')->nullable()->after('reference');
        });

        Schema::table(
            'revenues', function (Blueprint $table) {
                $table->string('add_receipt')->nullable()->after('reference');
            });
        Schema::table(
            'invoice_payments', function (Blueprint $table) {
                $table->string('add_receipt')->nullable()->after('reference');
            });
        Schema::table(
            'bill_payments', function (Blueprint $table) {
                $table->string('add_receipt')->nullable()->after('reference');
            });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            //
        });
        Schema::table('revenues', function (Blueprint $table) {
            //
        });
        Schema::table('invoice_payments', function (Blueprint $table) {
            //
        });
        Schema::table('bill_payments', function (Blueprint $table) {
            //
        });
    }
};
