<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Complaints extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('complaints', function(Blueprint $print){
           $print->increments('complaint_id');
            $print->string('complaint',250);
            $print->integer('status');
            $print->integer('attend_to');
            $print->integer('admin_id');
            $print->integer('added_by');
            $print->rememberToken();
            $print->timestamps();
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
    }
}
