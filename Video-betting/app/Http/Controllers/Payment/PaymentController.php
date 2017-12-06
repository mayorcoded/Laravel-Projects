<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Bet\BetController;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use App\User;
use App\Providers\WalletServiceProvider;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ProfileController;
use Paystack;

class PaymentController extends Controller
{
    private $walletServiceProvider, $profileController;
    private $transer_code;
    private $otp;


    public function __construct(WalletServiceProvider $walletServiceProvider)
    {
        $this->walletServiceProvider = $walletServiceProvider;
        $this->profileController = new ProfileController();
    }

    public function redirectToGateway()
    {
        return Paystack::getAuthorizationUrl()->redirectNow();
    }

    /**
     * Obtain Paystack payment information
     * @return void
     */
    public function handleGatewayCallback(Request $request)
    {
        $paymentDetails = Paystack::getPaymentData();

        $paystack_status = $paymentDetails['status'];

        if( $paystack_status === true ){
            $transaction_type  = "DEPOSIT";
            $transaction_amount = $paymentDetails['data']['amount']/100;
            $transaction_status  = $paymentDetails['status'];

            $__ = $this->walletServiceProvider->updateUserTransaction($transaction_type,$transaction_amount, $transaction_status);

            if($request->session()->has('checkout')){
                //now initialize the betcheckout
                $betController = new BetController();
                $betController->checkoutCallback($__, $request);
                $request->session()->remove('checkout');
            }

        }


        //dd($paymentDetails );

        return redirect()->route('profile');
    }

    public function showPage(){
        $user_id = $this->getAuthenticatedUserId();

        $user = User::where('user_id', $user_id)->get()[0];
        return view('paymentpage', compact('user'));
    }

    public function withdraw(){
        $amount = $_GET['amount'];
        $recipient =  $this->walletServiceProvider->createTransferRecipient();

        if($this->balanceIsEnough($amount)) {

            if ($recipient['status'] == '1') {
                $recipient_code = $recipient['data']['recipient_code'];
                $initiate = $this->walletServiceProvider->initiateTransfer($amount, $recipient_code);

                if ($initiate['status'] === true) {

                    $transaction_type = "WITHDRAWAL";
                    $transaction_amount = $initiate['data']['amount'] / 100;
                    $transaction_status = $initiate['status'];

                    $result =  $this->walletServiceProvider->updateUserTransaction($transaction_type, $transaction_amount, $transaction_status);
                    return $result;//'Thanks. Your transaction has been queued for processing.<br>You will get a message from us.'; //$initiate; //strval($initiate['data']['transfer_code']);
                } else return 'Could not complete transaction due to: ' . $initiate['message'];
            } else {
                return 'Could not complete transaction due to: ' . $recipient['message'];
            }
        }else return 'Invalid Transaction. Your balance in insufficient.';

    }

    public function finalizeWithdrawal(){
        $transfer_code = $_GET['code'];
        $otp = $_GET['otp'];

        $response = $this->walletServiceProvider->finalizeTransfer($transfer_code, $otp);
        return strval($response['message']);
    }

    public function getAuthenticatedUserId(){
        $id = Auth::id();
        return $id;
    }

    public function createCustomer(){
        return $this->walletServiceProvider->createCustomer();
    }

    public function balanceIsEnough($amount){
        $user_id = $this->getAuthenticatedUserId();

        $user = User::where('user_id', $user_id)->get()[0];
        if(($user->balance - $amount) < 50){
            return false;
        }

        return true;
    }

    public function checkIfAccountExist(){
        return $this->walletServiceProvider->getUserAccountDetails();
    }
}