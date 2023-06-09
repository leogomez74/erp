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
        Schema::create('saturation_deductions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('employee_id');
            $table->integer('deduction_option');
            $table->string('title');
            $table->integer('amount');
            $table->integer('created_by');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('saturation_deductions');
    }
};
