<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Artisan;

class CreatePricePlansTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('price_plans',
                       function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('number_of_appointments_per_day');
            $table->integer('number_of_reminders_per_appointment');
            $table->integer('sms_total');
            $table->string('support');
            $table->float('price');
            $table->string('paypal_plan_id')->nullable();
            $table->timestamps();
        });

        Artisan::call('db:seed', array('--class' => 'PricePlansTableSeeder'));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('price_plans');
    }

}
