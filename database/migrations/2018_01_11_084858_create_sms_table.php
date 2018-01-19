<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSmsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sms',
                       function (Blueprint $table) {
            $table->increments('id');
            $table->text('content');
            $table->string('from_number');
            $table->string('from_name');
            $table->string('to');
            $table->dateTime('send_at');
            $table->string('status')->nullable();
            $table->boolean('queued')->default(0);
            $table->boolean('failed')->default(0);
            $table->boolean('sent')->default(0);
            $table->boolean('delivered')->default(0);
            $table->boolean('undelivered')->default(0);
            $table->string('sid')->nullable();
            $table->integer('appointment_id')->unsigned()->index();
            $table->foreign('appointment_id')->references('id')->on('appointments')->onDelete('cascade');
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
        Schema::dropIfExists('sms');
    }

}
