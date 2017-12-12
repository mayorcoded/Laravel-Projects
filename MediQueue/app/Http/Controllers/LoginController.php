<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Auth;
use Validator;



class LoginController extends Controller
{
    //
    public function student(Request $request){
        $validate = Validator::make($request->all(),[
            'email'  =>  'required|exists:users,email',
            'password'  =>  'required'
        ],[
            'email.required'    =>  'Input your login detail',
            'email.exists'    =>  'This account is yet to be registered',
        ]);
        if($validate->fails()){
            //prepare error
            $error = $validate->errors()->has('email') ? $validate->errors()->first('email'): $validate->errors()->first('password');
            return json_encode(['status'    => false,'message'  => $error]);
        }
        $email = $request->get('email');
        $password = $request->get('password');

        if(Auth::attempt(['email' => $email, 'password' => $password])){
            if(Auth::check()) {
                
                return json_encode([
                    'status' => true,
                    'message' => 'Login successfull... wait while you are redirected '
                ]);
            }
        }

        return json_encode([
            'status' =>  false,
            'message'   =>  'Invalid Username or password'
        ]);
    }
}
