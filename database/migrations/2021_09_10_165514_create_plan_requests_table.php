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
        Schema::table('users', function (Blueprint $table) {
            $table->integer('requested_plan')->default(0)->after('plan_expire_date');
        });

        Schema::create('plan_requests', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('plan_id');
            $table->string('duration', 20)->default('monthly');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plan_requests');
    }
};
