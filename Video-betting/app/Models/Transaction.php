<?php

namespace App\Models;

use App\Bet;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    //
    protected $table = 'transactions';

    protected $primaryKey = 'transaction_id';

    protected $fillable = [ 'transaction_type', 'amount', 'user_id', 'status','created_at', 'updated_at',];

    public function bet(){
        return $this->belongsTo(Bet::class,'transaction_id','transaction_id');
    }
}
