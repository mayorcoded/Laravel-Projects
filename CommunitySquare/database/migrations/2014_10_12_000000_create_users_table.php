<?php

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
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('username')->unique();
            $table->string('email')->unique();
            $table->string('password');
            $table->string('age');
            $table->string('local_government');
            $table->string('states');
            $table->string('address');
            $table->string('area');
            $table->integer('user_level');
            $table->integer('activate');
            $table->string('profile_pic');
            $table->string('conf_code');
            $table->string('pwd_recovery');
            $table->integer('pwd_val');
            $table->integer('pwd_time');
            $table->rememberToken();
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
        Schema::drop('users');
    }
}
