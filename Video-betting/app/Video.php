<?php

namespace App;

use App\Models\Artist;
use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    //
    protected $primaryKey = 'video_id';

    public function artist(){
        return $this->hasOne(Artist::class, 'artist_id', 'artist_id');
    }

}
