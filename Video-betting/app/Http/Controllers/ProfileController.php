<?php

namespace App\Http\Controllers;

use App\Http\Statuses\BankAccountTypes;
use App\Models\BankAccount;
use App\User;
use Illuminate\Http\Request;
use Auth;
use Validator;

class ProfileController extends Controller
{
    //
    public function index(){
        $user_id = Auth::user()->user_id;
        $user = User::where('user_id', $user_id)->first();
        $bets = User::where('user_id', $user_id)->first()->bets()->simplePaginate(10);
        $transactions = $user->transactions()->simplePaginate(10);

        $account_details = User::where('user_id',$user_id)
            ->first()
            ->bankAccounts()
            ->first();

        $account_type = isset($account_details->account_type) ? $account_details->account_type : '';
        $account_name = isset($account_details->account_name) ? $account_details->account_name : '';
        $account_number = isset($account_details->account_number) ? $account_details->account_number : '';
        $bank = isset($account_details->bank) ? $account_details->bank : '';
        $bank_sort_code = isset($account_details->bank_sort_code) ? $account_details->bank_sort_code : '';
        return view('account', compact('user','bets','account_type','bank_sort_code','account_name','bank','account_number','transactions'));
    }
    
    public function updateAccount(Request $request){
        //the only updatables iin the user profile is the account details
        $validate = Validator::make($request->all(),[
            'account_number'    =>  'required|digits_between:7,20|numeric',
            'account_name'    =>  'required|string|min:3|max:70',
            'bank'    =>  'required|string|min:3|max:200',
            'bank_sort_code'    =>  'required|digits_between:3,6',
        ]);
        $err = '';
        if(isset($request->all()['account_type'])){
            $account_type = $request->all()['account_type'];
//            dd((new BankAccountTypes())->check($account_type));

            if(!(new BankAccountTypes())->check($account_type)){
                $err = 'Invalid account number provided';
            }
        }else{
            $err = 'Invalid account type provided';
        }

        if($validate->fails() || $err != ''){
            $msg = [
                'status'    =>  false,
                'message'   =>  [
                    'account_number'    =>  $validate->errors()->first('account_number'),
                    'account_name'      =>  $validate->errors()->first('account_name'),
                    'account_type'      =>  $err,
                    'bank'              =>  $validate->errors()->first('bank'),
                    'bank_sort_code'              =>  $validate->errors()->first('bank_sort_code'),
                ]
            ];
        }else{
            $bank = BankAccount
                ::where('user_id',Auth::user()->user_id);


            if($bank
                ->limit(1)
                ->count() == 1){
                //update
                $bank->update([
                    'account_number'    =>  $request->all()['account_number'],
                    'account_name'      =>  $request->all()['account_name'],
                    'bank'              =>  $request->all()['bank'],
                    'account_type'              =>  $request->all()['account_type'],
                    'bank_sort_code'              =>  $request->all()['bank_sort_code']
                ]);
            }else{
                //insert
                $bank = new BankAccount();
                $bank->account_number = $request->all()['account_number'];
                $bank->account_name = $request->all()['account_name'];
                $bank->bank = $request->all()['account_number'];
                $bank->account_type = $request->all()['account_type'];
                $bank->bank_sort_code = $request->all()['bank_sort_code'];
                $bank->user_id = Auth::user()->user_id;
                $bank->save();
            }


            $msg = [
                'status'    =>  true,
                'message'   =>  'Account information has been updated!'
            ];
        }

        $user_id = Auth::user()->user_id;
        $user = User::where('user_id', $user_id)->first();
        $bets = User::where('user_id', $user_id)->first()->bets()->simplePaginate
        (10);


        $account_type =$request->all()['account_type'];
        $account_name =$request->all()['account_name'];
        $account_number =$request->all()['account_number'];
        $bank =$request->all()['bank'];
        $bank_sort_code =$request->all()['bank_sort_code'];
        $transactions = $user->transactions()->simplePaginate(10);

        return view('account', compact('user','bets','msg','account_type','bank_sort_code','account_name','account_number','bank','transactions'));
    }
    public static function getSessionToken(){
        return session('user_session_token');
    }
}
