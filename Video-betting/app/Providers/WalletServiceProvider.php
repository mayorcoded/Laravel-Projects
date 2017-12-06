<?php
/**
 * Created by PhpStorm.
 * User: DELL
 * Date: 4/13/2017
 * Time: 3:57 PM
 */

namespace App\Providers;

use App\User;
use App\Models\BankAccount;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;


class WalletServiceProvider
{
    private $data;
    private $transfer_code;

    public function __construct()
    {

    }

    public function payStackApi($url,$data){

        //$result = array();

        $postdata =  json_encode($data);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);  //Post Fields
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $headers = [
            'Authorization: Bearer sk_test_39666ad46369178858e421b721c7c45ec82eb1f2',
            'Content-Type: application/json',
        ];
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $request = curl_exec ($ch);

        curl_close ($ch);

        if ($request) {
            $result = json_decode($request,true);
        }

        return $result;
    }

    public function createCustomer(){
        $user = $this->getUserDetails();
        $name = explode( " ", $user->fullname);
        $first_name = $name[0];
        $last_name = $name[1];
        $phone = $user->mobile_number;
        $email = $user->email;

        $data = array('email' => $email, "first_name" => $first_name,
                        'last_name' => $last_name, 'phone' => $phone);
        $url = "https://api.paystack.co/customer";

        return $this->payStackApi($url, $data);
    }

    public function createTransferRecipient(){

        $user_details = $this->getUserAccountDetails();
        $name = $user_details->account_name;
        $account_number = $user_details->account_number;
        $bank_code = $user_details->bank_sort_code;

        $data = array('type' => 'nuban', "name" => $name,"description" => 'Fund Transfer',
            'account_number' => $account_number, 'bank_code' => $bank_code,
            'currency' => 'NGN', 'metadata'=>['name'=> $name]);

        $url = "https://api.paystack.co/transferrecipient";

        return $this->payStackApi($url, $data);
    }

    public function checkPaystackBalance(){
        $data = array();
        $url = "https://api.paystack.co/balance";

        return $this->payStackApi($url, $data);
    }

    public function initiateTransfer($amount, $recipient_code){
        $data = array('source' => 'balance', 'reason' => 'Bet winnings', 'amount' => $amount * 100,
            "recipient" => $recipient_code );
        $url = "https://api.paystack.co/transfer";

        return $this->payStackApi($url, $data);
    }

    public function resendOTP($tranfer_code){
        $data = array("transfer_code" => $tranfer_code);
        $url  = 'https://api.paystack.co/transfer/resend_otp';

        return $this->payStackApi($url, $data);
    }

    public function finalizeTransfer( $transfer_code , $otp){
        $data = array("transfer_code" =>  $transfer_code, "otp" => $otp);
        $url = "https://api.paystack.co/transfer/finalize_transfer";
        return $this->payStackApi($url, $data);
    }

    public function getAuthenticatedUserId(){
        $id = Auth::id();
        return $id;
    }

    public function getUserAccountDetails(){

        $user_id = $this->getAuthenticatedUserId();

        $bankAccount = BankAccount::where('user_id', $user_id)->get()->first();

        if(sizeof($bankAccount) === 0 ){
            return 'none';
        }
        return $bankAccount;
    }

    public function getUserDetails(){

        $user_id = $this->getAuthenticatedUserId();

        $user = User::where('user_id', $user_id)->get()->first();

        return $user;
    }

    public function updateUserTransaction($transaction_type ,$transaction_amount, $transaction_status){
        $user_id = $this->getAuthenticatedUserId();

        //update user balance
        $balance_details = $this->increaseOrReduceUserBalance($transaction_amount, $transaction_type);

        $transaction = new Transaction;


        $transaction->transaction_type = $transaction_type;
        $transaction->amount = $transaction_amount;
        $transaction->status = $transaction_status;
        $transaction->user_id = $user_id;
        $transaction->save();

        $row = Transaction::where('user_id', $user_id)->get();
        $transaction_row = $this->generateTransactionRow($row[sizeof($row)-1], sizeof($row));

        return ['success',$balance_details, $transaction_row, 'transaction_id'=>$transaction->getIncrementing()];
    }

    public function increaseOrReduceUserBalance($amount, $transaction_type){

        $user_id = $this->getAuthenticatedUserId();

        $user = User::where('user_id', $user_id)->get();

        if($transaction_type === "DEPOSIT") {
            $new_balance = $user[0]->balance + $amount;
        }elseif ($transaction_type === "WITHDRAWAL"){
            $new_balance = $user[0]->balance - $amount;
        }else
            return $user;

        $user = User::updateOrCreate(
            ['user_id' => $user_id],
            ['balance' => $new_balance]
        );

        return $user;
    }

    public function generateTransactionRow($transaction, $index){
        $transaction =  json_decode($transaction,true);
        $index = ($index % 10 == 0)? 10: $index % 10;
        $id = \App\Http\Controllers\Bet\BetItem::trailingChar($transaction['transaction_id'],8);
        $type = $transaction['transaction_type'];
        $status = \App\Http\Statuses\TransactionStatus::statusMessage($transaction['status']);
        $amount = number_format($transaction['amount']);
        $time = $transaction['created_at'];

        $transaction_row = '<tr><td>' . $index .'</td><td>'. $id.'</td>'.
                            '<td>'. $type .'</td>'.
                            '<td>' . $status .'</td>'.
                            '<td>N'. $amount.'</td>' .
                            '<td>MVB</td>' . '<td>'. $time.'</td>'  . '</tr>';
        return $transaction_row;
    }


}