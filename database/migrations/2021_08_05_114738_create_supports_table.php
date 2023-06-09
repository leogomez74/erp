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
            'supports', function (Blueprint $table) {
                $table->id();
                $table->string('subject');
                $table->integer('ticket_created')->default(0);
                $table->integer('user')->default(0);
                $table->string('priority');
                $table->date('end_date');
                $table->string('ticket_code')->nullable();
                $table->string('status')->default(0);
                $table->string('attachment')->nullable();
                $table->integer('created_by');
                $table->text('description')->nullable();
                $table->timestamps();
            }
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('supports');
    }
};
