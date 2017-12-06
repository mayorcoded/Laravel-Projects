<?php
/**
 * Created by PhpStorm.
 * User: Mayowa
 * Date: 4/1/2017
 * Time: 1:48 PM
 */
Route::group(["middleware" => ["auth"]],function(){

    Route::get('profile', [
        'uses'  =>  'ProfileController@index',
        'as'    =>  'profile'
    ]);
    Route::post('profile', [
        'uses'  =>  'ProfileController@updateAccount',
        'as'    =>  'profile.update'
    ]);

    Route::get('bet/slip/get',[
       'uses'   =>  'Bet\BetController@getUserBet',
           'as' =>  'bet.get'
    ]);

});
