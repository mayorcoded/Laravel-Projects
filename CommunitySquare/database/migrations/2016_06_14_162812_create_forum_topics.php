<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateForumTopics extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('forum_topics', function (Blueprint $table) {
            $table->increments('id');
            $table->string('created_by');
            $table->string('title');
            $table->string('active');
            $table->text('content');
            $table->string('local_government');
            $table->string('age_group');
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
        Schema::drop('forum_topics');
    }
}
