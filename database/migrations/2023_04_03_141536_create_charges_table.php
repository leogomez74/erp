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
        Schema::create('charges', function (Blueprint $table) {
            $table->id();
            $table->date('date')->nullable();
            $table->char('day', 2)->nullable();
            $table->string('company');
            $table->string('charge_type');
            $table->string('periodicity');
            $table->string('category');
            $table->decimal('amount', 15, 2);
            $table->char('currency', 3)->default('₡');
            $table->tinyInteger('status')->default(0); //0 pendiente, 1 aprobado, 2 rechazado
            $table->text('observation')->nullable();
            $table->integer('created_by');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('charges');
    }
};
