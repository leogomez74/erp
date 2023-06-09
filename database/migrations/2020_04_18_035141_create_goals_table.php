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
        Schema::create(
            'goals', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('name');
                $table->string('type');
                $table->string('from')->nullable();
                $table->string('to')->nullable();
                $table->float('amount')->default(0.00);
                $table->integer('is_display')->default(1);
                $table->integer('created_by')->default(0);
                $table->timestamps();
            }
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('goals');
    }
};
