<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BetCart extends Model
{
    //
    protected $primaryKey ='item_id';

    protected $table = 'bet_cart';

    protected $fillable = [];


    public function video(){
        return $this->hasOne(Video::class, 'video_id','video_id');
    }
    public function user(){
        return $this->belongsTo(User::class, 'session_id','user_session_token');
    }

    
}
