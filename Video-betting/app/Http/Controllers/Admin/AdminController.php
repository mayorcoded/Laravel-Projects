<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\SettingsController;
use App\Models\Artist;
use App\Models\Channel;
use App\Video;
use Illuminate\Http\Request;
use Validator;

class AdminController extends Controller
{
    //
    public function setup(Request $request){
        $artists = Artist::all();
        return view('admin.setup', [
            'artists' => $artists,
            'request'   =>  $request
        ]);
    }

    public function getChannel(){
        $channels = Channel::all();
        return view('admin.channel_add', [
            'channels' => $channels
        ]);
    }

    public function moderation(){
        $videos = Video::all();
        return view('admin.moderation', [
            'videos' => $videos
        ]);
    }

    public function settings(Request $request){
//        fetch previous settings
        $settings = new SettingsController();
        return view('admin.settings',compact('settings'));
    }

    public function updateSettings(Request $request){
        $validate = Validator::make($request->all(),$val = [
            'cash_out_limit'    =>  'numeric',
            'game_limits'    =>  'numeric',
            'stake_limits'    =>  'numeric',
            'starting_credit'    =>  'numeric',
        ]);
        if($validate->fails()){
            $errors = $validate->errors();
            return $this->settings($request)->with([
                'cash_out_limit_error'  =>  $errors->first('cash_out_limit'),
                'game_limits_error'  =>  $errors->first('game_limits'),
                'stake_limits_error'  =>  $errors->first('stake_limits'),
                'starting_credit_error'  =>  $errors->first('starting_credit'),
                'error'     =>  'Settings not updated please correct errors'
            ]);
        }

        (new SettingsController())->set([
            'cash_out_limit'  =>  $request->get('cash_out_limit'),
            'game_limits'  =>  $request->get('game_limits'),
            'stake_limits'  =>  $request->get('stake_limits'),
            'starting_credit'  =>  $request->get('starting_credit'),
        ]);

        return $this->settings($request)->with([
            'success'   =>  'Settings updated'
        ]);

    }


    public function regError(){
        echo session('error');
    }

    public function account(){
        echo 'welcome';
        print_r(Auth::user());
    }

    public function createArtist(Request $request){
        
    }
}
