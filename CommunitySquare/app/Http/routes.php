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

Route::get('/', function () {
    return view('index');
});

Route::post('register', 'AccountController@store');
Route::post('login', 'AccountController@doLogin');
Route::get('/logout', 'AccountController@getLogout');
Route::get('geo/lg/{state}', function($state){
   $loadAll = new \App\Http\Controllers\GeoController();
    $allLg = $loadAll->getStateLg($state);
    $data = array('status'=>true, 'data'=>$allLg);
    return json_encode($data);
});
Route::get('account/activate/{email}/{code}', function($email, $code){
   $activae =  new \App\Http\Controllers\AccountController();
    $suc = $activae->activateUser($email, $code);
    $data = $suc;
    return view('status')->withData($data);
});
Route::get('profile/{username}', function($username){
    $fetch = \App\User::where('username', $username);
    $fetch2 = \App\User::where('username', $username)->where('activate','1');
    if($fetch2->count() > 0){
        $data = $fetch->get()[0];
        return view('profile')->withData($data);
    }else if($fetch->count() > 0) {
        $data = array('status'=>false, 'title'=>'Inactive Profile', 'message'=>'The account with the username '.$username.' is not active');
        $data = json_encode($data);
        return view('status')->withData($data);
    }else{
            $data = array('status'=>false, 'title'=>'Profile not Found', 'message'=>'The account with the username '.$username.' does not exist on out server');
            $data = json_encode($data);
            return view('status')->withData($data);
        }

});
Route::get('community', function(){
   return view('community');
});
Route::get('community/topics/{lg_id}', function($lg_id){
    //check if the $lg exist
    $checkLG = new \App\Http\Controllers\GeoController();
    if($checkLG->getLG($lg_id) != null && $checkLG->getLG($lg_id)->count() > 0){
        $data = $checkLG->getLG($lg_id);

        $geo = new \App\Http\Controllers\GeoController();
        $lg_id = $geo->getLgId($data->lg)[0]->id;
        $topicsGet = new \App\Http\Controllers\ForumController();
        $topics = $topicsGet->getTopicLg2($data->lg)->paginate(15);
        return view('topics-lg', ['data'=>$data, 'topics'=>$topics, 'lg_id'=>$lg_id]);
    }else{
        $data = array('status'=>false, 'title'=>'Invalid Community', 'message'=>'This community is not registered on community square');
        $data = json_encode($data, true);
        return view('status')->withData($data);
    }
});
Route::post('topic/add', 'ForumController@postAddTopic')->middleware(['auth']);
Route::get('topics/{topic_id}', function($topic_id){
    $topic = new \App\Http\Controllers\ForumController();
    if($topic->getTopic($topic_id)->count() >0) {

        $topic = $topic->getTopic($topic_id);
        $commentController = new \App\Http\Controllers\ForumCommentController();
        $comments = $commentController->getTopicComments($topic_id);
        return view('each-topic',['topic'=>$topic, 'comments'=>$comments]);
    }
    else {
        $data = array('status' => false, 'title' => 'Invalid Topic', 'message' => 'This topic does not exist or might have been deleted');
        $data = json_encode($data, true);
        return view('status')->withData($data);
    }
});
Route::post('topics/{topic_id}', 'ForumCommentController@postComment')->middleware(['auth']);
Route::get('profile/update/true', function(){

    $fetch = \App\User::where('username', Auth::user()->username);
    $data = $fetch->get()[0];
    return view('profile-edit')->withData($data);
})->middleware(['auth']);
Route::post('profile/update/true', 'AccountController@postUpdate')->middleware(['auth']);
Route::post('profile/update/profile_pic', 'AccountController@profilePicUpdate')->middleware(['auth']);
Route::get('password/reset', function(){
   return view('password-reset');
});
Route::post('password/reset', 'AccountController@postReset');
Route::get('password/reset/true', 'AccountController@validateReset');
Route::get('topics/{id}/edit', 'AdminController@getEditPost')->middleware(['admin']);
Route::post('topics/{id}/edit', 'AdminController@postEditPost')->middleware(['admin']);
Route::get('topics/{id}/delete', 'AdminController@getDeletePost')->middleware(['admin']);
Route::get('comment/{id}/edit', 'AdminController@getEditComment')->middleware(['admin']);
Route::get('comment/{id}/delete', 'AdminController@getDeleteComment')->middleware(['admin']);
Route::post('comment/{id}/edit', 'AdminController@postEditComment')->middleware(['admin']);
Route::get('addadmin', 'AdminController@getAddAdmin')->middleware(['admin']);
Route::post('addadmin', 'AdminController@postAddAdmin')->middleware(['admin']);
Route::get('ela', function(){
    $username = 'wik';
    $client = Elasticsearch\ClientBuilder::create()->build();
    $param = array();
    $param['body']= array(
        'username'=>$username
    );
    $param['index'] = 'uses';
    $param['type']  = 'users';
    $result = $client->index($param);
    var_dump($result);
});