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
        Schema::create(
            'assets', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('name');
                $table->date('purchase_date');
                $table->date('supported_date');
                $table->float('amount')->default(0.00);
                $table->text('description')->nullable();
                $table->integer('created_by')->default(0);
                $table->timestamps();
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
        Schema::dropIfExists('assets');
    }
};
