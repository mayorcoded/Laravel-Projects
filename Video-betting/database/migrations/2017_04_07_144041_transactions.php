<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Transactions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        if(!Schema::hasTable('transactions'))

            //for bank transactions
            Schema::create('transactions', function (Blueprint $table) {
                $table->increments('transaction_id');
                $table->string('transaction_type');
                $table->string('amount')->nullable();
                $table->integer('user_id');
                $table->integer('status');
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
        Schema::dropIfExists('transactions');
    }
}
