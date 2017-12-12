<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', 'LandingController@index');
Route::post('login', [
    'as'    =>  'login',
    'uses'  =>  'LoginController@student'
]);
Route::post('register', [
    'as'    =>  'register',
    'uses'  =>  'LandingController@registerStudent'
]);

Route::group([
    'middleware'  =>  'auth',
    'prefix'  =>  'account',
], function(){
    Route::get('/', [
        'as' =>  'student.home',
        'uses'  =>  'LandingController@account'
    ]);
    Route::post('queue/create', [
        'as'    =>  'queue.create',
        'uses'  =>  'QueueController@createQueue'
    ]);
    Route::get('test', function(){
        return '<form method="post" action="/account/queue/create"><input name="message"><input  name="admin_id"><input type="submit"></form>';
    });
    Route::get('logout', 'LandingController@logout');
});

Route::group([
    'middleware'    => 'auth_admin',
    'prefix'        =>  'admin'
], function(){
    Route::get('/', 'LandingController@adminIndex');
});