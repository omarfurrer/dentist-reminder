<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSmsHistoryTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sms_history',
                       function (Blueprint $table) {
            $table->increments('id');
            $table->string('status');
            $table->string('error_code')->nullable();
            $table->integer('sms_id')->unsigned()->index();
            $table->foreign('sms_id')->references('id')->on('sms')->onDelete('cascade');
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
        Schema::dropIfExists('sms_history');
    }

}
