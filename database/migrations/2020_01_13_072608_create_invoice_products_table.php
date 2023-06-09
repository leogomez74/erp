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
            'invoice_products', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->integer('invoice_id');
                $table->integer('product_id');
                $table->integer('quantity');
                $table->float('tax')->default('0.00');
                $table->float('discount')->default('0.00');
                $table->float('price')->default('0.00');
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
        Schema::dropIfExists('invoice_products');
    }
};
