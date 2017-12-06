<?php
/**
 * Created by PhpStorm.
 * User: Orisatoberu
 * Date: 4/1/2017
 * Time: 11:08 AM
 */

namespace App\Http\Controllers\Bet;


use App\Bet as BetModel;
//use App\Bet;
//use App\Bet;
use App\BetCart;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\Wallet\WalletController;
use App\Http\Statuses\BetStatus;
use App\Http\Statuses\PaymentStatus;
use App\Http\Statuses\TransactionStatus;
use App\Providers\WalletServiceProvider;
use App\User;
use App\Video;
use Carbon\Carbon;
use Auth;
use Illuminate\Http\Request;

class BetItem
{
    protected $bet;

    protected $error_bag;

    public function __construct(\App\Http\Controllers\Bet\Bet $bet=null)
    {
        $this->bet = $bet;
    }

    public function getError($name = null){
        return $name == null ? $this->error_bag
            : (isset($this->error_bag[$name])
                ? $this->error_bag[$name] : '');
    }
    public function create(){
        $bet = new BetCart();

        $bet->video_id = $this->bet->video_id;
        $bet->maximum_view =$this->bet->maximum_view;
        $bet->expiry_date =$this->bet->expiry_date;
        $bet->odds = $this->bet->odd;
        $bet->amount_deposited =$this->bet->betAmount;
        $bet->price =$this->bet->price;
        $bet->user_session_token =$this->bet->user_session;
        $bet->save();

    }
    public function delete(){
        Bet::where('bet_id', $this->bet->bet_id)->delete();
    }

    public function validate(){
        //validates bet item
        //check if user already added to cart the video bet

        /* if(Video::where('video_id', $this->bet->video_id)->count()
             > 0){

         }else {
             $this->error_bag['video'] = 'This video does not exist';
             return false;
         }*/

        if((new User)->cartItems()->where('video_id', $this->bet->video_id)->count()
            == 0){
            if((new User)->cartItems()->count() > (new SettingsController())->get('game_limits') ){
                $this->error_bag['video'] = 'Game limits has been exceeded';

                return false;
            }
            return true;
        }

        $this->error_bag['video'] = 'This video does not exist';

        return false;
    }

    public function betItemExist($user=false){
        if(!$user)
            return BetCart::where('user_session_token',ProfileController::getSessionToken())
                ->where('video_id', $this->bet->video_id)
                ->count() > 0;

        return User::where('user_id',Auth::id())
            ->first()
            ->cartItems()
            ->where('video_id', $this->bet->video_id)
            ->count() > 0;
    }

    public function createBet($trasaction_id = 1, Request $request=null){

        $betsInCart = (new User)
            ->where('user_id',Auth::user()->user_id)
            ->first()
            ->cartItems()
            ->get();
        $betDeatils = [];
        $amount_to_be_gained = 0;
        foreach ($betsInCart as $betsInCart){
            $betDeatils['videos_id'][] = $betsInCart->video_id;
            $betDeatils['maximum_views'][] = $betsInCart->maximum_views;
            if(!isset($betDeatils['expiry_date']))
                $betDeatils['expiry_date'] =$betsInCart->expiry_date;
            elseif(strtotime($betsInCart->expiry) > strtotime($betsInCart->expiry)){
                $betDeatils['expiry_date'] = $betsInCart->expiry;
            }
            $betDeatils['amounts_receivable'][] =$betsInCart->price;
            $betDeatils['amounts_placed'][] =$betsInCart->amount_deposited;
            $betDeatils['odds'][] =$betsInCart->odds;
            $betDeatils['ending_dates'][] =$betsInCart->expiry;
            $amount_to_be_gained += $betsInCart->price;

        }

        $betDeatils['amount'] =$amount_to_be_gained;

        $bet_ = new BetModel();
        $bet_->user_id = Auth::user()->user_id;
        $bet_->expiry_date = $betDeatils['expiry_date'];
        $bet_->amount = $betDeatils['amount'];
        $bet_->bet_status = BetStatus::ONGOING;
        $bet_->payment_status = PaymentStatus::UNPAID;
        $bet_->payment_date = Carbon::now();
        $bet_->transaction_id = $trasaction_id;
        $bet_->save();

        $bet_id = $bet_->getIncrementing();
//        print_r($betDeatils);
        for ($i=0; $i < count( $betDeatils['videos_id']); $i++){
            $this->betItemHolderCreate($bet_id,
                $betDeatils['videos_id'][$i],
                null,
                $betDeatils['maximum_views'][$i],
                $betDeatils['amounts_placed'][$i],
                $betDeatils['odds'][$i],
                $betDeatils['ending_dates'][$i],
                $betDeatils['amounts_receivable'][$i]);
        }
        $this->emptyCart();
        $this->checkAndDeduct($request);
    }

    public function checkAndDeduct(Request $request){
        if(!$request->session()->has('checkout_amount'))
            return ;
        $amount_to_deduct  = $request->session()->get('checkout_amount');

        $this->deduct($amount_to_deduct, Auth::id());
        $request->session()->remove('checkout_amount');
    }

    public function deduct($amount, $user){
        //then deduct the amount from the user and redirect to the homepage
        WalletController::decrementAccountBalance($amount);

        //add to transactino record
        $wallectController = new WalletServiceProvider();
        $wallectController->updateUserTransaction(TransactionStatus::WALLET_WITHDRAW, $amount, true);

    }

    public function betItemHolderCreate($bet_id, $video_id, $min_view, $max_view, $amount_placed,$odd,$ending_time, $amount_recievable){
        $bet_ = new \App\BetItem();
        $bet_->bet_id = $bet_id;
        $bet_->video_id = $video_id;
        $bet_->maximum_view = $max_view;
        $bet_->amount_placed = $amount_placed;
        $bet_->odd = $odd;
        $bet_->ending_date = $ending_time;
        $bet_->amount_receivable = $amount_recievable;
        $bet_->save();
    }

    public function getCartSession(){
        return ProfileController::getSessionToken();
    }

    public function emptyCart(){
        BetCart
            ::where('user_session_token', $this->getCartSession())
            ->delete();
    }

    public function isCartEmpty(){
        return (new User)
            ->where('user_id', Auth::id())
            ->first()
            ->cartItems()
//            ->where('user_session_token', $this->getCartSession())
            ->limit(1)
            ->count() == 0;
    }

    public function exists(){
        //check if bet item exists based on bet_id
        return BetCart
            ::where('bet_id',$this->bet->bet_id)
            ->limit(1)
            ->count()== 1;
    }

    public function update(){

        $bet = BetCart::where('video_id',$this->bet->video_id)
            ->where('user_session_token', ProfileController::getSessionToken())
            ->update([

                'video_id' => $this->bet->video_id,
                'maximum_view' => $this->bet->maximum_view,
                'expiry_date' => $this->bet->expiry_date,
                'odds' => $this->bet->odd,
                'amount_deposited' => $this->bet->betAmount,
                'price' => $this->bet->price,

            ]);

    }
//    public function isBet
    public static function trailingChar($string, $character_no,$character='0'){
        $no_of_trailing_zero = $character_no-count($string);
        for($i=$no_of_trailing_zero; $i > 0; $i--){
            $string = '0'.$string;
        }
        return $string;
    }

    public static function getTotalCartItemAmount(User $user = null){
        $user = $user == null
            ? User::where('user_id', Auth::id())
            : $user;
        $user = $user->first();
//        echo $us;;
        $betItems = $user->cartItems()->get();
        $amount = 0;
        foreach ($betItems as $betItem){
            $amount += $betItem->amount_deposited;
        }

        return $amount;
    }

    public static function duration($date1, $date2=null){
        $time1 = strtotime($date1);
        if($date2 != null)
            $time2 = strtotime($date2);
        else
            $time2 = time();

        $diff = $time1-$time2;

        if($diff < 0){
            if($date2 != null)
                $time1 = strtotime($date2);
            else
                $time1 = time();
            $time2 = strtotime($date1);

            $diff = $time1-$time2;
        }
        if($diff < 60){
            return round($diff).' seconds';
        }

        $diff = (int) $diff/60;

        if($diff < 60)
            return round($diff).' minutes';

        $mins = $diff%60;
        $diff = (int) $diff/60;

        if($diff < 24){
            return round($diff).' hours '.round($mins).' minutes';
        }

        $hours = $diff%24;
        $diff = $diff/24;
        return round($diff).' days '.round($hours).' hours';
    }
    
    public function getBet($bet_id){
        return \App\Bet::where('bet_id', $bet_id)->first();
    }
}