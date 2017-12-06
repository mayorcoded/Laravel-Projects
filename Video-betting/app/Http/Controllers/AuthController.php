<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class AuthController extends Controller
{
    //
    protected  $drivers = [
        'facebook',
        'google',
    ];
    public function loginDriver($driver, Request $request){
        if(!$this->checkDriver($driver))
            return response("",404);
        $authuser = new AuthenticateUser();
        $authuser->driver = $driver;
        return $authuser->execute();
    }

    public function checkDriver($driver){
        return in_array($driver, $this->drivers);
    }

    public function login($driver, Request $request){
        if(!$this->checkDriver($driver))
            return response("",404);
        $authuser = new AuthenticateUser();
        $authuser->driver = $driver;
        return $authuser->execute($request);

    }

    public function logout(){
        Auth::logout();
        return Redirect::route('index');
    }
}
