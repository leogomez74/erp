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
            'proposal_products', function (Blueprint $table) {
                $table->string('tax', '50')->nullable()->change();
            }
        );
        Schema::table(
            'invoice_products', function (Blueprint $table) {
                $table->string('tax', '50')->nullable()->change();
            }
        );
        Schema::table(
            'bill_products', function (Blueprint $table) {
                $table->string('tax', '50')->nullable()->change();
            }
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table(
            'proposal_products', function (Blueprint $table) {
                $table->dropColumn('tax');
            }
        );
        Schema::table(
            'invoice_products', function (Blueprint $table) {
                $table->dropColumn('tax');
            }
        );
        Schema::table(
            'bill_products', function (Blueprint $table) {
                $table->dropColumn('tax');
            }
        );
    }
};
