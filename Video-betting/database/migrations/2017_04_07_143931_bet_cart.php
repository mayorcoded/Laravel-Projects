<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class BetCart extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('bet_cart')) {
            return;
        }
        //
        //for bank bets
        if(!Schema::hasTable('bet_cart'))
            Schema::create('bet_cart', function (Blueprint $table) {
                $table->increments('item_id');
                $table->integer('video_id');
                $table->string('minimum_view')->nullable();
                $table->string('maximum_view')->nullable();
                $table->dateTime('expiry_date');
                $table->string('user_session_token')->nullable();
                $table->double('odds',80,3);
                $table->double('price',80,4);
                $table->double('amount_deposited',80,4);
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
        Schema::dropIfExists('bet_cart');
    }
}
