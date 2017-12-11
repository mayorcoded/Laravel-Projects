<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Lg extends Model
{
    //
    protected $table = 'forum_geo_local_government';
    protected $fillable = ['lg', 'state_id'];
}
