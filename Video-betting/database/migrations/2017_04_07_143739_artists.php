<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Artists extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        if(!Schema::hasTable('artists'))

        //FOR ARTISTS
            Schema::create('artists', function (Blueprint $table) {
                $table->increments('artist_id');
                $table->text('description')->nullable();
                $table->string('name')->unique();
                $table->string('nickname')->nullable();
                $table->string('featured')->nullable();
                $table->integer('reputation')->nullable();
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
        Schema::dropIfExists('artists');
    }
}
