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
            $table->string('billing_name')->nullable()->change();
            $table->string('billing_country')->nullable()->change();
            $table->string('billing_state')->nullable()->change();
            $table->string('billing_city')->nullable()->change();
            $table->string('billing_phone')->nullable()->change();
            $table->string('billing_zip')->nullable()->change();
            $table->text('billing_address')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        //
    }
};
