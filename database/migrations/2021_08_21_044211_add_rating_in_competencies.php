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
        Schema::table(
            'indicators', function (Blueprint $table) {
                $table->string('rating')->nullable()->after('designation');
            }
        );

        Schema::table(
            'appraisals', function (Blueprint $table) {
                $table->string('rating')->nullable()->after('employee');
            }
        );
        Schema::table(
            'goal_trackings', function (Blueprint $table) {
                $table->string('rating')->nullable()->after('subject');
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
        Schema::table(
            'indicators', function (Blueprint $table) {
                $table->dropColumn('rating');
            }
        );
        Schema::table(
            'appraisals', function (Blueprint $table) {
                $table->dropColumn('rating');
            }
        );
        Schema::table(
            'goal_trackings', function (Blueprint $table) {
                $table->dropColumn('rating');
            }
        );
    }
};
