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
            'deal_emails', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->unsignedBigInteger('deal_id');
                $table->string('to');
                $table->string('subject');
                $table->text('description')->nullable();
                $table->foreign('deal_id')->references('id')->on('deals')->onDelete('cascade');
                $table->timestamps();
            }
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('deal_emails');
    }
};
