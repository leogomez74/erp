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
        if (! Schema::hasTable('task_checklists')) {
            Schema::create('task_checklists', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->integer('task_id');
                $table->string('user_type');
                $table->integer('created_by');
                $table->integer('status')->default(0);
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('task_checklists');
    }
};
