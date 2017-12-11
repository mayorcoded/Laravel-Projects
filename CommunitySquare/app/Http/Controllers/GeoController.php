<?php

namespace App\Http\Controllers;

use App\State;
use App\Lg;
use Illuminate\Http\Request;

use App\Http\Requests;

class GeoController extends Controller
{
    //this controls geographical locations
    public function getAllStates(){
        $state = State::all();
        return $state;
    }
    public function getState($id){
        $state = State::find($id);
        return $state;
    }
    public function getAllLG(){
        $lg = Lg::all();
        return $lg;
    }
    public function getLG($id){
        $lg = Lg::find($id);
        return $lg;
    }
    public function getStateLg($state_id){
        $lg = Lg::where('state_id', $state_id)->get();
        return $lg;
    }
    public function getStateId($state){
        $state = State::where('state', $state)->get();
    }
    public function getLgId($lg){
        $Ld = Lg::where('lg', $lg)->get();
        return $Ld;
    }
    public function getLgState($lg){
        $lg = Lg::where('id',$lg)->orWhere('lg',$lg)->get();
        if($lg->count() > 0){
             $state_id = $lg[0]->state_id;
            return $this->getState($state_id);
        }else
            return $lg;
    }
    public static function plural($int){
        if($int > 1)
            return 's';
        else
            return '';
    }
    public function convertToAgo($time){
        //the time expeced in this instance 2016-08-09 16:07:31
        list($year, $month, $day) = explode('-',explode(' ',$time)[0]);
        list($hour, $min, $sec) = explode(':',explode(' ',$time)[1]);
        if($year < date('Y'))
            $ago = date('Y')-$year.' year'.self::plural(date('Y')-$year).' ago';
        else if($month < date('m'))
            $ago = date('m')-$month.' month'.self::plural(date('m')-$month).' ago';
        else if($day < date('d'))
            $ago = date('d')-$day.' day'.self::plural(date('d')-$day).' ago';
        else if($hour < date('H'))
            $ago = date('H')-$hour.' hour'.self::plural(date('H')-$hour).' ago';
        else if($min < date('i'))
            $ago = date('i') - $min.' minute'.self::plural(date('i')-$min).' ago';
        else
            $ago = 'Just now';

        return $ago;
    }
}
