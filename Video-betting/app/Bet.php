<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bet extends Model
{
    //
    protected $table = 'bets';

    protected $primaryKey = 'bet_id';

    public function betItems(){
        return $this->hasMany(BetItem::class, 'bet_id','bet_id');
    }
}
