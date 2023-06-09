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
            'company_policies', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->integer('branch');
                $table->string('title');
                $table->text('description');
                $table->string('attachment')->nullable();
                $table->integer('created_by');
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
        Schema::dropIfExists('company_policies');
    }
};
