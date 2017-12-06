<?php

namespace App\Http\Controllers\Wallet;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;

class WalletController extends Controller
{
    //

    public static function getAccountBalance($user_id=null){
        if($user_id == null)
            $user_id = Auth::id();
        $user = User::where('user_id', $user_id)->first();

        return $user->balance;
    }

    public static function decrementAccountBalance($amount, $user_id=null){
        if($user_id == null)
            $user_id = Auth::id();
        $user = User::where('user_id', $user_id)
            ->decrement(
                'balance'   ,  $amount
            );

        return /*$user->balance*/;
    }

    public static function incrementAccountBalance($amount, $user_id=null){
        if($user_id == null)
            $user_id = Auth::id();
        $user = User::where('user_id', $user_id)->first();

        return $user->balance;
    }


}
