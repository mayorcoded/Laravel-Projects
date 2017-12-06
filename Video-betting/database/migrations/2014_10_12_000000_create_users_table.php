<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('users'))

            Schema::create('users', function (Blueprint $table) {
            $table->increments('user_id');
            $table->string('username')->nullable();
            $table->string('fullname')->nullable();
            $table->string('avatar')->nullable();
            $table->string('social_media_handle')->nullable();
            $table->string('email')->unique();
            $table->dateTime('last_login')->nullable();
            $table->dateTime('date_of_birth')->nullable();
            $table->string('mobile_number')->nullable();
            $table->integer('role')->nullable();
            $table->double('balance')->nullable();
            $table->rememberToken();
            $table->string('session_key')->nullable();
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
        Schema::dropIfExists('users');
    }
}
