<?php

namespace App;

use App\Models\BankAccount;
use App\Models\Transaction;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'balance',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $primaryKey = 'user_id';

    public function bets($query=null){
        return $this->hasMany(Bet::class, 'user_id', 'user_id');
    }

    public function cartItems(){
        return $this->hasMany(BetCart::class,'user_session_token','session_key');
    }

    public function bankAccounts(){
        return $this->hasMany(BankAccount::class,'user_id', 'user_id');
    }

    public function transactions(){
        return $this->hasMany(Transaction::class, 'user_id', 'user_id');
    }
    
}
