<?php
/**
 * Created by PhpStorm.
 * User: Orisatoberu
 * Date: 3/27/2017
 * Time: 3:54 AM
 */

namespace App\Http\Validations;


use Carbon\Carbon;

class Terms
{
    protected $user;

    protected $violates = false;

    protected $error_bag = [];

    protected $driver;

    protected $socialite_user;

    public function __construct($user = null, $driver = null)
    {
        $this->user = $user;
        $this->socialite_user = $user;
        $this->driver = $driver;
    }

    public function validate($user=null){
        if($user == null)
            $user = $this->user;
        $dob = ($this->driverCompact('date_of_birth') != null) ? $this->driverCompact('date_of_birth') : Carbon::now();
        if($this->isUnderAge($dob)){
            $this->violates = true;
            $this->error_bag['age'] = 'Your age violates our terms and condition that you must be 18+ to use our service';
        }
    }

    public function violatesTerms(){
        return
        $this->violates;
    }

    public function isUnderAge($date_of_brith){

        $date = explode(' ', $date_of_brith)[0];
        $year = explode('-',$date)[0];

        return (((int) strftime('%Y', time())-$year) < env('age_limit'));
    }
    public function driverCompact($name){
        if($this->driver == 'facebook')
            return $this->facebook($name);
        return $this->google($name);
    }
    public function facebook($name){

        switch ($name){
            case 'fullname':
                return $this->socialite_user->name;
            case 'username':
                return $this->socialite_user->email;
            case 'avatar':
                return @$this->socialite_user->avatar_original;
            case 'social_media_handle':
                return $this->socialite_user->profileUrl;
            case 'id':
                return $this->socialite_user->id;
            case 'email':
                return $this->socialite_user->email;
            case 'mobile_number':
                return $this->socialite_user->pages_messaging_phone_number;
            case 'date_of_birth':
                return $this->socialite_user->birthday;

        }
    }
    public function google($name){
        switch ($name){
            case 'fullname':
                return $this->socialite_user->name;
            case 'username':
                return $this->socialite_user->email;
            case 'avatar':
                return @$this->socialite_user->avatar_original;
            case 'social_media_handle':
                return $this->socialite_user->user['url'];
            case 'id':
                return $this->socialite_user->id;
            case 'email':
                return $this->socialite_user->email;
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

    public function reset(){
        $this->user = null;
        $this->violates = false;
        $this->error_bag = [];
    }

    public function setUser($user){
        $this->user = $user;
    }

    public function getError($name=null){
        if($name == null)
            return $this->error_bag;
        if(isset($this->error_bag[$name]))
            return $this->error_bag[$name];

        return '';
    }



}