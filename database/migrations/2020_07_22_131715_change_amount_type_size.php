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
            'goals', function (Blueprint $table) {
                $table->float('amount', 25, 2)->default(0.00)->change();
            }
        );

        Schema::table(
            'revenues', function (Blueprint $table) {
                $table->float('amount', 25, 2)->default(0.00)->change();
            }
        );

        Schema::table(
            'payments', function (Blueprint $table) {
                $table->float('amount', 25, 2)->default(0.00)->change();
            }
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table(
            'goals', function (Blueprint $table) {
                $table->dropColumn('amount');
            }
        );

        Schema::table(
            'revenues', function (Blueprint $table) {
                $table->dropColumn('amount');
            }
        );

        Schema::table(
            'payments', function (Blueprint $table) {
                $table->dropColumn('amount');
            }
        );
    }
};
