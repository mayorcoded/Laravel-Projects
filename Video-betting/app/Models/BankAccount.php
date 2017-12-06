<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BankAccount extends Model
{
    //
    protected $table = 'bank_accounts';

    protected $primaryKey = 'account_id';

    protected $fillable = ['account_name', 'account_number', 'bank', 'user_id', 'account_type' ];
    
}
