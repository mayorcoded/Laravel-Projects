<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Video extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('videos'))

                //
            //for videos
            Schema::create('videos', function (Blueprint $table) {
                $table->increments('video_id');
                $table->string('youtube_id')->nullable();
                $table->integer('artist_id');
                $table->double('odd',4,3);
                $table->string('title')->nullable();
                $table->text('description');
                $table->integer('bets');
                $table->string('image',360)->nullable();
                $table->integer('featured')->nullable();
                $table->integer('active')->default(1);
                $table->string('views');
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
        Schema::dropIfExists('videos');
    }
}
