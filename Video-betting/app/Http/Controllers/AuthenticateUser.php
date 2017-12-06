<?php
/**
 * Created by PhpStorm.
 * User: Orisatoberu
 * Date: 3/25/2017
 * Time: 11:08 AM
 */

namespace App\Http\Controllers;


use App\Http\Validations\Terms;
use App\Roles\Role;
use App\User;
use Auth;
use Carbon\Carbon;
use Laravel\Socialite\Two\InvalidStateException;

class AuthenticateUser
{
    public $users;
    public $socialites;
    public $auth;
    public $driver;
    private $errors;
    private $socialite_user;

    public function execute($request=null){
        $code = '';/*
        if($request instanceof Request){
            $code = $request->get('code');
        }elseif(is_array($request)){
            $code = isset($request['code']) ? $request['code'] : '';
        }*/

        if($request == null)
            return $this->needsAuthentication();
        try {
            $user = \Socialite::driver($this->driver)->user();
        
        }catch (InvalidStateException $e){
            return redirect(route('login_facebook',$this->driver));

        }catch (\Exception $e){
            return redirect('');
        }

        $user = $this->authenticatable($user);

        if($user instanceof User){
//            dd(session('r_url'));
            return $this->authenticate($user);
        }
//        dd($user);
        if(!is_bool($user))
            return $user;

        return redirect('/');
    }

    public function authenticate($user){
        if(!Auth::check()) {
            Auth::login($user);
        }
        $ses = session('r_url');
        
        return ($ses != '') ?
            redirect($ses)
            :  redirect('/');
    }

    public function needsAuthentication(){
        return \Socialite::driver($this->driver)->redirect();
    }

    public function authenticatable($user){
        $this->socialite_user = $user;

        //this will check to add the user or to just login the user
        if($this->driverCompact('mobile_number') != null)
            $authUser = User::where('email',$this->driverCompact('email'))
            ->orWhere('mobile_number',$this->driverCompact('mobile_number'))
            ->first();
        else
            $authUser = User::where('email',$this->driverCompact('email'))
            ->first();
        

        if ($authUser) {
            return $authUser;
        }

        if($this->violatesTerm($user))
            return redirect(route('registration_error'))->with('error',$this->errors);
        return $this->createUser($user);
    }

    protected function createUser($user){
//        print_r($user->user);
//        dd($user);
//        echo '<br>';
//        echo '<br>';
//        echo '<br>';
//        echo '<br>';
//        print_r($user->user);

/*       return  User::insert([
            'fullname' => $this->driverCompact('fullname'),
            'username' => $this->driverCompact('id'),
            'avatar' => $this->driverCompact('avatar'),
            'social_media_handle' => $this->driverCompact('social_media_handle'),
            'last_login'    =>  Carbon::now(),
            'email' =>  $this->driverCompact('email'),
            'date_of_birth' => ($this->driverCompact('date_of_birth') != null) ? $this->driverCompact('date_of_birth') : Carbon::now(),
            'mobile_number' =>  ($this->driverCompact('mobile_number') != null) ? $this->driverCompact('mobile_number') : '',
            'role'      =>  Role::USER,
            'balance'   =>  env('INITIAL_USER_BALANCE'),
            'session_key' => 'ddkkk',
            'created_at' => Carbon::now()
        ]);*/

        $min_bal  = (new SettingsController())->get('starting_credit');
        $user = new User();
        $user->fullname = $this->driverCompact('fullname');
        $user->username = $this->driverCompact('id');
        $user->avatar = $this->driverCompact('avatar');
        $user->social_media_handle = $this->driverCompact('social_media_handle');
        $user->last_login = Carbon::now();
        $user->email = $this->driverCompact('email');
        $user->date_of_birth = ($this->driverCompact('date_of_birth') != null) ? $this->driverCompact('date_of_birth') : Carbon::now();
        $user->mobile_number = ($this->driverCompact('mobile_number') != null) ? $this->driverCompact('mobile_number') : '';
        $user->role = Role::USER;
        $user->balance = $min_bal == '' ? env('INITIAL_USER_BALANCE') : $min_bal;
        $user->session_key = ProfileController::getSessionToken();
        $user->created_at = Carbon::now();
        $user->save();
        return $user;
    }

    public function driverCompact($name){
        if($this->driver == 'facebook')
            return $this->facebook($name);
        return $this->google($name);
    }
    public function facebook($name){

        switch ($name){
            case 'fullname':
                return @$this->socialite_user->name;
            case 'username':
                return @$this->socialite_user->email;
            case 'avatar':
                return @$this->socialite_user->avatar_original;
            case 'social_media_handle':
                return @$this->socialite_user->profileUrl;
            case 'id':
                return @$this->socialite_user->id;
            case 'email':
                return @$this->socialite_user->email;
            case 'mobile_number':
                return @$this->socialite_user->pages_messaging_phone_number;
            case 'date_of_birth':
                return @$this->socialite_user->birthday;

        }
    }
    public function google($name){
        switch ($name){
            case 'fullname':
                return @$this->socialite_user->name;
            case 'username':
                return @$this->socialite_user->email;
            case 'avatar':
                return @$this->socialite_user->avatar_original;
            case 'social_media_handle':
                return @$this->socialite_user->user['url'];
            case 'id':
                return @$this->socialite_user->id;
            case 'email':
                return @$this->socialite_user->email;
            case 'mobile_number':
                return '';
            case 'date_of_birth':
                if(isset($this->socialite_user->user['ageRange'])){
                    return (((int)strftime('%Y',time())) - $this->socialite_user->user['ageRange']['min']).'-01-01 00:00:00';
                }
                else {
                    return null;
                }
        }
    }

    public function violatesTerm($user= null){
        if($user == null)
            $user = $this->users;
        
        $terms = new Terms($user);
        $terms->validate();
        if($terms->violatesTerms()) {
            $this->errors = $terms->getError();
            return true;
        }
        return false;
    }


}