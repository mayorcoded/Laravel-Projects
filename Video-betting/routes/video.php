<?php
/**
 * Created by PhpStorm.
 * User: KayLee
 * Date: 25/04/2017
 * Time: 11:39 PM
 */

Route::get('videos', [
    "as" => "videos",
    "uses" => 'Video\VideoController@index'
]);

//    video route. ID is a Crypt of the natural id
Route::get('video/{id}', [
    'uses'  =>  'Video\VideoController@home',
    'as'    =>  'video'
]);
Route::get('video/get/api', [
    'uses'  =>  'Video\VideoController@getVideo',
    'as'    =>  'video.get.json'
]);

Route::get('video/1/test', 'Video\VideoController@video');