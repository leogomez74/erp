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
        Schema::table(
            'allowances',
            function (Blueprint $table) {
                $table->string('type')->nullable()->after('amount');
            }
        );
        Schema::table(
            'commissions',
            function (Blueprint $table) {
                $table->string('type')->nullable()->after('amount');
            }
        );
        Schema::table(
            'loans',
            function (Blueprint $table) {
                $table->string('type')->nullable()->after('amount');
            }
        );
        Schema::table(
            'saturation_deductions',
            function (Blueprint $table) {
                $table->string('type')->nullable()->after('amount');
            }
        );
        Schema::table(
            'other_payments',
            function (Blueprint $table) {
                $table->string('type')->nullable()->after('amount');
            }
        );
        Schema::table(
            'overtimes',
            function (Blueprint $table) {
                $table->string('type')->nullable()->after('rate');
            }
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('allowance', function (Blueprint $table) {
            //
        });
    }
};
