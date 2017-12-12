<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;

class AccountController extends Controller
{
    //
    public static function getAllAdmins(){
        $users = User::where('level',1)->get();
        return $users;
    }
}
