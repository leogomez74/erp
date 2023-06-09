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
        if (! Schema::hasTable('task_files')) {
            Schema::create('task_files', function (Blueprint $table) {
                $table->id();
                $table->string('file');
                $table->string('name');
                $table->string('extension');
                $table->string('file_size');
                $table->integer('task_id');
                $table->String('user_type');
                $table->integer('created_by');
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('task_files');
    }
};
