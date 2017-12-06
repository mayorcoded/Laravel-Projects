<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBetItems extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        if(!Schema::hasTable('bet_items'))
            Schema::create('bet_items', function(Blueprint $table){
            $table->increments('bet_item_id');
            $table->integer('bet_id');
            $table->text('video_id')->nullable();
            $table->text('minimum_view')->nullable();
            $table->text('maximum_view')->nullable();
            $table->text('amount_placed')->nullable();
            $table->text('odd')->nullable();
            $table->text('ending_date')->nullable();
            $table->text('amount_receivable')->nullable();
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
        Schema::dropIfExists('bet_items');

    }
}
