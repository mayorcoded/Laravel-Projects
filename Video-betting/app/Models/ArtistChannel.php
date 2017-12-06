<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ArtistChannel extends Model
{
    //
    protected $table = 'artist_channel';

    public function channel(){
        return $this->hasOne(Channel::class,'channel_id','channel_id');
    }
}
