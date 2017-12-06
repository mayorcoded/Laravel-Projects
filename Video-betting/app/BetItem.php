<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BetItem extends Model
{
    //
    protected $table = 'bet_items';

    protected $primaryKey = 'bet_item_id';

    public function video(){
        return $this->hasOne(Video::class, 'video_id','video_id');
    }
}
