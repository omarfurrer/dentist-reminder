<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClinicsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clinics',
                       function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('number_of_reminders_per_appointment')->default(3);
            $table->text('sms_template');
            $table->integer('price_plan_id')->unsigned()->index();
            $table->foreign('price_plan_id')->references('id')->on('price_plans')->onDelete('cascade');
            $table->boolean('billing_agreement_active')->default(false);
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
        Schema::dropIfExists('clinics');
    }

}
