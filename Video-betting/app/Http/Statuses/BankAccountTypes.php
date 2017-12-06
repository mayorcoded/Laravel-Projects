<?php
/**
 * Created by PhpStorm.
 * User: Orisatoberu
 * Date: 4/5/2017
 * Time: 2:43 PM
 */

namespace App\Http\Statuses;


class BankAccountTypes
{
    protected static $account_types = [
        'current',
        'savings'
    ];

    public function check($name){
        return in_array(strtolower($name),self::$account_types);
    }

    public function get(){

        return self::$account_types;
    }
}