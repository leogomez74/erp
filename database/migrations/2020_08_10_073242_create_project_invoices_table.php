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
            'project_invoices', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('invoice_id');
                $table->unsignedBigInteger('project_id');
                $table->unsignedBigInteger('client_id');
                $table->unsignedBigInteger('tax_id');
                $table->date('due_date');
                $table->integer('created_by');
                $table->smallInteger('status')->default(1);
                $table->timestamps();
            }
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('project_invoices');
    }
};
