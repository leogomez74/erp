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
    public function up()
    {
        Schema::create('venders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('vender_id');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('contact')->nullable();
            $table->string('avatar', 100)->default('');
            $table->integer('created_by')->default(0);
            $table->integer('is_active')->default(1);
            $table->timestamp('email_verified_at')->nullable();
            $table->string('billing_name');
            $table->string('billing_country');
            $table->string('billing_state');
            $table->string('billing_city');
            $table->string('billing_phone');
            $table->string('billing_zip');
            $table->text('billing_address');
            $table->string('shipping_name');
            $table->string('shipping_country');
            $table->string('shipping_state');
            $table->string('shipping_city');
            $table->string('shipping_phone');
            $table->string('shipping_zip');
            $table->text('shipping_address');
            ///database new data added by ahixel rojas 23/09/2022 at 16:00
            $table->integer('account_number');
            $table->tinyInteger('pay_type');
            //////////////////////////////////////////
            $table->string('lang')->default('en');
            $table->rememberToken();
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
        Schema::dropIfExists('venders');
    }
};
