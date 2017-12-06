<?php

namespace App\Models;

use App\Video;
use Illuminate\Database\Eloquent\Model;

class Artist extends Model
{
    //
    protected $table = 'artists';

    protected $primaryKey = 'artist_id';

    public function videos(){
        return $this->hasMany(Video::class,$this->primaryKey,$this->primaryKey);
    }
    public function video($video_id){
        return $this->videos()->where('video_id', $video_id);
    }

    public function channels(){
        return $this->hasMany(ArtistChannel::class,$this->primaryKey,$this->primaryKey);
    }
    

}
