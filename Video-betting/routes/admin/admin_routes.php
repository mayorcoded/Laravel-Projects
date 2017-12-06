<?php
Route::group(["middleware" => ["auth"]],function(){

    Route::get('admin', [
        'as' => 'setup',
        'uses' => 'Admin\AdminController@setup']);

    Route::post('admin', [
        'as' => 'admin.artist.add',
        'uses' => 'Artist\ArtistController@create']);

    Route::post('update/{artist_id}', [
        'as' => 'admin.artist.update',
        'uses' => 'Artist\ArtistController@update']);

    Route::get('channels/add', [
        'as' => 'admin.channel.add',
        'uses' => 'Admin\AdminController@getChannel']);

    Route::post('channels/add', [
        'as' => 'admin.channel.add.post',
        'uses' => 'Video\VideoController@addChannel']);

    Route::get('moderation', [
        'as' => 'moderation',
        'uses' => 'Admin\AdminController@moderation'
    ]);
    Route::get('settings', [
        'as' => 'settings',
        'uses' => 'Admin\AdminController@settings'
    ]);
    Route::post('settings',[
        'as' =>  'settings.update',
        'uses'  =>  'Admin\AdminController@updateSettings'
    ]);

    Route::get('video/moderate/active_inactive','Video\VideoController@active_inactiveVideo');
    Route::get('video/moderate/feature_un-feature','Video\VideoController@feature_unfeatureVideo');

    Route::get('videos/channel/add', 'Video\VideoController@addChannel');
    Route::get('videos/channel/videos/crawl/{id}', 'Video\VideoController@crawlVideos');
});