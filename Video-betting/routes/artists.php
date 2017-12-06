<?php

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Route::get('artists', ['as' => 'artists', 'uses' => 'Artist\ArtistController@index']);
Route::get('artist/{id}', ['as' => 'artist', 'uses' => 'Artist\ArtistController@home']);