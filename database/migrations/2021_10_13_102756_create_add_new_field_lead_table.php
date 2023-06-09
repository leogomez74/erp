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
        Schema::table(
            'leads', function (Blueprint $table) {
                $table->string('phone')->nullable()->after('email');
            }
        );
        Schema::table(
            'deals', function (Blueprint $table) {
                $table->string('phone')->nullable()->after('name');
            }
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('  add_new_field_lead');
    }
};
