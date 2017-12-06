<?php
/**
 * Created by PhpStorm.
 * User: DELL
 * Date: 4/8/2017
 * Time: 12:19 PM
 */

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\BankAccount;


class SettingsController
{

    public function getRaw($setting){
        return Setting::where('name',$setting)->first();
    }

    public function get($setting){
        $setting = Setting::where('name',$setting)->first();

        if(count($setting) == 0)
            return '';
        return $setting->value;
    }
    public function set($name,$value=null){
        if(!is_array($name)){
            $name = [$name => $value];
        }

        foreach ($name as $name_ => $value_){
            if($this->exist($name_))
                $this->update($name_,$value_);
            else
                $this->create($name_,$value_);
        }

    }
    public function exist($setting){
        return Setting::where('name',$setting)->limit(1)->count() > 0;
    }

    private function update($name,$value){
        Setting::where('name',$name)->update([
           'name'   =>  $name,
            'value' =>  $value
        ]);
    }

    private function create($name,$value){
        $set_ = new Setting();
        $set_->name = $name;
        $set_->value = $value;
        $set_->save();
    }
/*    public function updateAccountDetails(Request $request){
        // Get the currently authenticated user's ID...
        $user_id = $this->getAuthenticatedUserId();

        $account_name = $request->input('account_name');
        $account_number = $request->input('account_number');
        $bank =  $request->input('bank');
        $account_type = $request->input('account_type');

        $bankAccount = new BankAccount();

        // If there's a user_id details on the table, update to the new one.
        // If no matching model exists, create one.
        $bankAccount::updateOrCreate(
            ['user_id' => $user_id],
            ['account_type' => $account_type, 'account_name' => $account_name, 'bank' => $bank,
                'account_number' => $account_number, 'user_id' => $user_id]
        );

        return $bankAccount;
    }

    public function getAuthenticatedUserId(){

        $id = Auth::id();
        return $id;
    }*/

}