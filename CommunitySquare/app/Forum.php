<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Forum extends Model
{
    //
    protected $table = 'forum_topics';
    protected $fillable = ['created_by', 'title', 'active', 'content', 'local_government','age_group'];
    
}
