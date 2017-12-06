<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Channels extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('channels'))

                //
            Schema::create('channels', function(Blueprint $table){
               $table->increments('channel_id');
                $table->string('title')->nullable();
                $table->string('youtube_id')->nullable();
                $table->text('description');
                $table->string('canvas',360)->nullable();
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
        Schema::dropIfExists('channels');
    }
}
