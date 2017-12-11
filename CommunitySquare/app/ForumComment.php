<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ForumComment extends Model
{
    //
    protected $table= 'forum_topics_comments';
    protected $fillable = ['topic_id', 'comment_by', 'active', 'comment'];
}
