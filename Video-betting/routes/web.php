<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
    //
use Illuminate\Auth\Middleware\Authenticate;

Route::group(['middleware' => ['web']], function () {

    Route::get('/', [
        'uses'  =>  'LandingController@index',
        'as'    =>  'index'
    ]);

    Route::get('admin', [
        'uses'  =>  'AdminController@index',
        'as'    =>  'admin'
    ]);


    Route::get('contact', [
        'uses'  =>  'LandingController@contact',
        'as'    =>  'contact'
    ]);

    Route::get('wik/', function(){
        echo var_dump(\Illuminate\Support\Facades\Auth::check());
        return 'welcome. Login with <a href="login/facebook">Facebook</a> <a href=""">Google</a>';

    });

    Route::get('login/{driver}', [
        'uses'  =>  'AuthController@loginDriver',
        'as'    =>  'login_facebook'
    ]);

    Route::get('login/{driver}/accept', [
        'uses'  =>  'AuthController@login',
        'as'    =>  'login_redirect'
    ]);

    Route::get('logout', [
        'uses' => 'AuthController@logout',
        'as' => 'logout'
    ]);

    Route::get('register/error/', [
        'uses'  =>  'LandingController@regError',
        'as'    =>  'registration_error'
    ]);

    Route::get('/checkaccount','Payment\PaymentController@checkIfAccountExist' );

    Route::post('/pay', 'Payment\PaymentController@redirectToGateway')->name('pay');

    Route::get('/payment/callback', 'Payment\PaymentController@handleGatewayCallback');

    Route::get('/showpay', 'Payment\PaymentController@showPage');

    Route::get('/withdraw', 'Payment\PaymentController@withdraw');

    Route::get('/finalize', 'Payment\PaymentController@finalizeWithdrawal');

    Route::get('/create', 'Payment\PaymentController@createCustomer');

    Route::get('/search', 'LandingController@search')->name('search');


    Route::post('/bet/cart/add', [
        'uses'   =>  'Bet\BetController@store',
        'as'    =>  'bet.cart.add'
    ]);

    Route::get('/bet/cart/get/no', [
       'as' =>  'bet.cart.number',
        'uses'  =>  'Bet\BetController@cartItemsNo'
    ]);
    Route::get('/bet/cart/get/item', [
       'as' =>  'bet.cart.item',
        'uses'  =>  'Bet\BetController@cartItem'
    ]);
    Route::get('/bet/cart/delete/{id}', [
       'as' =>  'bet.cart.item.delete',
        'uses'  =>  'Bet\BetController@deleteCartItem'
    ]);

    Route::get('/bet/cart', [
       'as' =>  'bet.cart.fetch',
        'uses'  =>  'Bet\BetController@cartDisplay'
    ]);

    Route::get('/bet/cart/checkout', [
        'uses'   =>  'Bet\BetController@checkout',
        'as'    =>  'bet.cart.get'
    ]);

    Route::get('/login', function(){
        if(!\Illuminate\Support\Facades\Auth::check()){
            return view('login');
        }
        else redirect('/');
    });

    //Route::get('/profile/update','SettingsController@updateAccountDetails')->middleware('auth');

//    Route::post('/update','SettingsController@updateAccountDetails')->middleware('auth')->name('update');
    require_once __DIR__."/user/routes.php";
    require_once __DIR__."/admin/admin_routes.php";
    require_once __DIR__."/artists.php";
    require_once __DIR__."/video.php";
});
