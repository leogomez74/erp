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
            'proposals', function (Blueprint $table) {
                $table->integer('is_convert')->default('0')->after('discount_apply');
                $table->integer('converted_invoice_id')->default('0')->after('discount_apply');
            }
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table(
            'proposals', function (Blueprint $table) {
                $table->dropColumn('is_convert');
                $table->dropColumn('converted_invoice_id');
            }
        );
    }
};
