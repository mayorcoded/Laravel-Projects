<?php

namespace App\Http\Middleware;

use App\BetCart;
use App\User;
use Closure;
use Auth;

class UserSessionToken
{
    /**
     * Handle an incoming request.
     *
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    protected  $request;

    public function handle($request, Closure $next,$guard=null)
    {
        $this->request = $request;


        if(!$this->exists()){
            //generate a session token for user
            $this->create();
        }
        
        if (Auth::guard($guard)->check()) {

            $this->migrate();
        }
        
        return $next($request);
    }

    public function create($key = null){
        if($key == null)
            $key =  $this->generate();
        //this creates the session token
        $this->request->session()->put('user_session_token', $key);
        $this->request->session()->save();
//        echo session('user_session_token');
        return $key;
    }

    public function get(){
        return $this->request->session()->get('user_session_token');
    }
    public function getUserSessionInTable($user_id){
        return User::where('user_id',$user_id)->first()->session_key;
    }
    public function migrate(){

        $user_id = Auth::id();
        $current_session = $this->get();
        $user_session = $this->getUserSessionInTable($user_id);
        if($user_session == '')
            $user_session = $this->create();

        //change the user session
        if($user_session != '' && $user_session != $current_session){

            $user_session = $this->create($user_session);
            //now migrate all transaction done with the current session to the new
            BetCart::where('user_session_token',$current_session)
                ->update([
                    'user_session_token'    =>  $user_session
                ]);
            User::where('user_id',$user_id)
                ->update([
                    'session_key'    =>  $user_session
                ]);
        }

    }

    public function generate(){
        $mc_time = microtime();
        $chars = [
          0,1,2,3,4,5,6,7,8,9,
            'a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t',
            'u','v','x','y','z',
//            '"','£','$','%','dh'
        ];
        $str = '';
        for($i=0; $i < 8; $i++){
            $str .= $chars[
            mt_rand(0,count($chars)-1)
            ];
        }
        $str .= $mc_time;

        //check that it doesnt exist in the database

        return $str ;
    }

    public function tokenExistInDB($token){

    }

    public function exists(){
        return $this->get() != NULL;
    }
}
