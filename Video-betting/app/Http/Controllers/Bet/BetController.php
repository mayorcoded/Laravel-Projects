<?php

namespace App\Http\Controllers\Bet;

use App\Bet;
use App\BetCart;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\Wallet\WalletController;
use App\Http\Statuses\BetStatus;
use App\Http\Statuses\PaymentStatus;
use App\Http\Statuses\TransactionStatus;
use App\Providers\OddGeneratorServiceProvider;
use App\Providers\WalletServiceProvider;
use App\User;
use App\Video;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Validator;
use Paystack;

class BetController extends Controller
{
    protected $errors;
    //
    public function store(Request $request){
        try {
            $bet = new \App\Http\Controllers\Bet\Bet(null, null, $request->get('video_id'));
            $bet->video_id = Crypt::decrypt($request->get('video_id'));
            $bet->expiry_date = $request->get('expiry');
            $bet->maximum_view = $request->get('maximum_view');
            $bet->betAmount = $request->get('amount');
            if (Auth::check())
                $bet->user_id = Auth::user()->user_id;
            $bet->user_session = ProfileController::getSessionToken();
        }catch (\Exception $e){
            return response()->json([
                'status'    =>  !true,
                'message'   =>  [
                    'video' =>  "The selected video does not exist or might have been deleted"
                ]
            ]);
        }
        if(!$this->validateUserBetData($request)){
            return response()->json([
                'status'    =>  !true,
                'message'   =>  $this->errors
            ]);
        }


        $betItem = new BetItem($bet);

        if(!$betItem->betItemExist()){
            //get video
            //then insert
            $bet->odd = $this->generateOdds($bet);
            $bet->odd = json_decode($bet->odd)->odds;
            $bet->odd = (double) round($bet->odd,3);
//            dd($bet->odd);
//            echo $bet->odd = '000'.($bet->odd);
            $bet->expiry_date = Carbon::createFromTimestamp(strtotime('+ '.$bet->expiry_date.' days', time()));
//            dd('');
            $bet->price = $this->generatePrice($bet->odd,$bet->betAmount);
            $betItem->create();

            return response()->json([
               'status' =>  !false,
                'message'   =>  'Bet successfully added to cart'
            ]);
        }else{
            //collect error from error bag

            $bet->odd = $this->generateOdds($bet);
            $bet->odd = json_decode($bet->odd)->odds;
            $bet->odd = (double) round($bet->odd,3);
//            echo $bet->odd = '000'.($bet->odd);
            $bet->expiry_date = Carbon::createFromTimestamp(strtotime('+ '.$bet->expiry_date.' days', time()));
//            dd('');
            $bet->price = $this->generatePrice($bet->odd,$bet->betAmount);
            $betItem->update();/*
            return response()->json([
                'status'    =>  !true,
                'message'   =>  $betItem->getError('video')
            ]);*/
            return response()->json([
                'status' =>  true,
                'message'   =>  'Bet successfully added to cart'
            ]);
        }
    }

    public function generatePrice($odd, $amount){
        return $amount + ($odd * $amount);
    }

    public function validateUserBetData(Request $request){
        $req = array_merge($request->all(),[
           'video_id'   => Crypt::decrypt($request->get('video_id'))
        ]);
        $validate = Validator::make($req,[
           'video_id'   =>  'required|exists:videos,video_id',
            'expiry'    =>  'required|integer|min:1',
            'maximum_view'  =>  'required|integer',
            'amount'  =>  'required|numeric|min:'.(new SettingsController())->get('stake_limits'),
        ]);

        if($validate->fails()){
            $this->errors = [
              'video'   =>  $validate->errors()->has('video_id') ? 'The operation could not be processed. reloading page might fix': '',
              'expiry'   =>  $validate->errors()->first('expiry'),
              'views'   =>  $validate->errors()->first('maximum_view'),
              'amount'   =>  $validate->errors()->first('amount'),
            ];
            return !true;
        }

        return !false;

    }

    public function deleteCartItem($id){
        $bet = BetCart::where('item_id', $id)
            ->where('user_session_token', ProfileController::getSessionToken())
            ->delete();
        if($bet == 0){
            return redirect(route('bet.cart.fetch'));
        }

    }

    public function cartItem(Request $request){
        $id = $request->get('id');


        $bet = BetCart::where('item_id', $id)
            ->where('user_session_token', ProfileController::getSessionToken())
            ->first();
        $failed = false;
        if(count($bet) > 0){
            $video = $bet->video()->first();
            if(count($video) > 0)
                $artist = $video->artist()->first();
            else
                $failed = !$failed;
        }else
            $failed = !$failed;

        if($failed){
            return response()->json([
                'status' =>  false,
                'message'   =>  'This bet was not found or might have ben deleted.'
            ]);
        }
        return response()->json([
            'status'    =>  true,
            'message'   =>  [
                'id'    =>  Crypt::encrypt($video->video_id),
                'video_name'    =>  $video->title,
                'video_image'    =>  $video->image,
                'description'   =>  $video->description,
                'number_of_views'   =>$video->views,
                'artist'    =>  $artist->name,
                'artist_description'    =>  $artist->description,
                'maximum_view'  =>  $bet->maximum_view,
                'expiry'  =>  explode(' ',BetItem::duration($bet->expiry_date,$bet->created_at))[0],
                'amount'  =>  $bet->amount_deposited,
                'odds'  =>  $bet->odds,
                'price'  =>  $bet->price,
            ]
        ]);
    }

    public function generateOdds(\App\Http\Controllers\Bet\Bet $bet){
//        echo $bet->video_id;
        $video = Video::where('video_id', $bet->video_id)->first();

        $views = $video->views;
        return OddGeneratorServiceProvider::getOdds($bet->expiry_date,$views,$bet->maximum_view);
    }
    public function addToCart($id){

    }

    public function cartDisplay(){
        //this display items in the user's cart in the blade
        $bets = BetCart::where('user_session_token',ProfileController::getSessionToken())->get();

        return view('bet.index',compact('bets'));
    }
    public function remove($id){
        $bet = new \App\Http\Controllers\Bet\Bet();
        $bet->bet_id = $id;
        $betItem  = new BetItem($bet);
        if($betItem->exists()){
            $betItem->delete();
            return json_encode([
                'status' =>  true,
                'message'   =>  'Bet item successfully removed from your cart'
            ]);
        }else{
            return json_encode([
                'status' =>  false,
                'message'   =>  'This bet does not exist in your cart or might have been previously deleted'
            ]);
        }
    }

    public function checkoutCallback(array $paymentDetail, Request $request=null){
        $betItem = new BetItem();
        if(!$betItem->isCartEmpty()){
            $betItem->createBet($paymentDetail['transaction_id'], $request);
        }
        
    }

    public function checkout(Request $request){
        if(!Auth::check()){
            //enforce login
            $request->session()->put('r_url',route('bet.cart.get'));
            $request->session()->save();
            return redirect('/login');
        }
        //validate payment
        $totalAmount = BetItem::getTotalCartItemAmount();
        $failed = false;
        $req = $request->all();


        //check if the user has amount in his wallet
        $accountBalance = WalletController::getAccountBalance();
        if($accountBalance > 0) {
            $diff  = $totalAmount - $accountBalance;

            if($diff <= 0){

//                dd('s');
                //then deduct the amount from the user and redirect to the homepage
                WalletController::decrementAccountBalance(($totalAmount));
//                dd(($accountBalance - $totalAmount));
                //add to transactino record
                $wallectController = new WalletServiceProvider();
                $trans = $wallectController->updateUserTransaction(TransactionStatus::WALLET_WITHDRAW, ($totalAmount), true);
                //then redirect to the account pg
//                dd($trans_id);
                $this->checkoutCallback(
                    $trans, $request);
                return redirect(route('profile'));
            }else{
                //the total amount is the diff
//                $totalAmount =

                $request->session()->put('checkout_amount',$accountBalance);
                $request->session()->save();
                $totalAmount = abs($diff);
            }
        }




        $totalAmount *= 100;


        if(!isset($req['amount']) || $req['amount'] != $totalAmount)
            $failed = true;

        if(!isset($req['email']) || $req['email'] != Auth::user()->email)
            $failed = true;


        //check amount in the wallet and deduct the curent amount from it
//        $diffAMount = $totalAmount - $this->getAccountBalance();
//
//        if($diffAMount > 0){
//            $totalAmount = $diffAMount;
//            //now deduct the amount from the user balance
//
//        }
        if($failed)
            return redirect(
                route('bet.cart.get').'?amount='.$totalAmount
                .'&key=' . config('paystack.secretKey').
                '&reference='. Paystack::genTranxRef().
                '&email=' . (Auth::user()->email)
            );
        //now redirect to payment page
//        dd($req);
        $request->session()->put('checkout','checkout__');
        $request->session()->save();
        return Paystack::getAuthorizationUrl()->redirectNow();
    }

    

    public function getUserBet(Request $request){
        $validate = Validator::make($request->all(), [
           'bet'    =>  'required'
        ]);

        $error = false;
        if($validate->fails()){
            $error = true;
        }
        else {
            $betItem = new BetItem();
            $bet = $betItem->getBet($request->get('bet'));

            if (count($bet) == 0)
                $error = true;
            else{
                if($bet->user_id != Auth::user()->user_id){
                    $error = true;
                }
                if(!$error){

                    $videos = explode(',',$bet->videos_id);
                    $min_views = explode(',',$bet->minimum_views);
                    $max_views = explode(',',$bet->maximum_views);
                    $amounts_placed = explode(',',$bet->amounts_placed);
                    $amounts_receivable = explode(',',$bet->amounts_receivable);
                    $ending_dates = explode(',',$bet->ending_dates);
                    $odds = explode(',',$bet->odds);
                    $amount = $bet->amount;
                    $payment_date = $bet->payment_date;
                    $payment_status = PaymentStatus::status($bet->payment_status);
                    $bet_status = BetStatus::status($bet->bet_status);
                    $bet_date = $bet->created_at;
                    $result = [];
                    for ($i=0; $i < count($videos); $i++){
                        $video = Video::where('video_id', $videos[$i])->first();

                        $result['bets'][] = [
                          'video_id' => $videos[$i],
                          'video_url' => route('video', $videos[$i]),
                          'name' => isset($video->title) ?$video->title : 'Video deleted' ,
                          'image' => isset($video->image) ?$video->image : '' ,
                          'min_views' => $min_views[$i],
                          'max_views' => $max_views[$i],
                          'amount_placed' => $amounts_placed[$i],
                          'amount_receivable' => $amounts_receivable[$i],
                          'ending_date' => $ending_dates[$i],
                          'odd' => $odds[$i],
                        ];
                    }
                    $result['bet_date'] = $bet_date;
                    $result['bet_status'] = $bet_status;
                    $result['payment_status'] = $payment_status;
                    $result['payment_date'] = $payment_date;
                    $result['total'] = $amount;


                }
            }
        }
        if($error)
            return response()->json([
                'status'    => false,
                'message'   =>  'This bet does not exist in your bet list'
            ]);
        return response()->json([
            'status'    => true,
            'message'   =>  $result
        ]);


    }

    public function cartItemsNo(){
        //this gets the current number of items in the user cart and return in json format
        return BetCart::where('user_session_token', ProfileController::getSessionToken())->count();
    }
    public function showOdds(){
        $days = $_GET['days'];
        $artist_rank = $_GET['rank'];
        $user_guess = $_GET['guess'];
        dd( \App\Providers\OddGeneratorServiceProvider::getOdds($days, $artist_rank, $user_guess) );
    }
}
