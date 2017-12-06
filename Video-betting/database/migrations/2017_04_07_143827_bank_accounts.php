<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class BankAccounts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        if(!Schema::hasTable('bank_accounts'))

            //for bank accounts
            Schema::create('bank_accounts', function (Blueprint $table) {
                $table->increments('account_id');
                $table->string('account_type')->nullable();
                $table->text('account_number')->nullable();
                $table->integer('user_id')->unique();
                $table->text('bank_sort_code');
                $table->string('bank')->nullable();
                $table->string('account_name')->nullable();
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
        Schema::dropIfExists('bank_accounts');
    }
}
