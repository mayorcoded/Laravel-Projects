<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Bets extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('bets'))

            //
            //for bank bets
            Schema::create('bets', function (Blueprint $table) {
                $table->increments('bet_id');
                $table->string('user_id')->nullable();
                $table->dateTime('expiry_date');
                $table->integer('bet_status');
                $table->integer('payment_status');
                $table->dateTime('payment_date')->nullable();
                $table->double('amount',50,3);
                $table->integer('transaction_id')->nullable();
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
        //
        Schema::dropIfExists('bets');
    }
}
