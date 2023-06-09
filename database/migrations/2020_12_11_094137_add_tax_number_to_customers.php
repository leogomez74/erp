<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::table('customers', function (Blueprint $table) {
            $table->string('tax_number')->nullable()->after('email');
        });

        Schema::table(
            'venders', function (Blueprint $table) {
                $table->string('tax_number')->nullable()->after('email');
            }
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('customers', function (Blueprint $table) {
            //
        });
        Schema::table('venders', function (Blueprint $table) {
            //
        });
    }
};
