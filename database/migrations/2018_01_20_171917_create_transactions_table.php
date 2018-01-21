<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransactionsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions',
                       function (Blueprint $table) {
            $table->increments('id');
            $table->string('transaction_id')->nullable();
            $table->string('order_number')->nullable();
            $table->string('response_msg')->nullable();
            $table->string('response_code')->nullable();
            $table->float('total')->nullable();
            $table->json('data')->nullable();
            $table->integer('clinic_id')->unsigned()->index();
            $table->foreign('clinic_id')->references('id')->on('clinics')->onDelete('cascade');
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
        Schema::dropIfExists('transactions');
    }

}
