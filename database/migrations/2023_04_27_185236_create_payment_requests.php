<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentRequests extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_requests', function (Blueprint $table) {
            $table->id();
            $table->date('date')->nullable();
            $table->char('day', 2)->nullable();
            $table->string('company');
            $table->string('payment_type');
            $table->string('periodicity');
            $table->string('periodicityd')->nullable();
            $table->string('category');
            $table->decimal('amount', 15, 2);
            $table->char('currency', 3)->default('₡');
            $table->tinyInteger('status')->default(0);
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
    public function down()
    {
        Schema::dropIfExists('payment_requests');
    }
}
