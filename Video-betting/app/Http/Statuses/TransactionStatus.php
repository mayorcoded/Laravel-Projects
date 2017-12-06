<?php
/**
 * Created by PhpStorm.
 * User: Orisatoberu
 * Date: 4/5/2017
 * Time: 3:23 PM
 */

namespace App\Http\Statuses;


class TransactionStatus
{
    const  USER_DEPOSIT = 0;

    const  ADMIN_DEPOSIT = 1;

    const  USER_WITHDRAW = 2;

    const  ADMIN_WITHDRAW = 3;

    const WALLET_WITHDRAW = 4;

    const WALLET_DEPOSIT = 5;

    public static function status($status){
        switch ($status){
            case TransactionStatus::ADMIN_DEPOSIT:
                return 'ADMIN DEPOSIT';
            break;
            case TransactionStatus::USER_DEPOSIT:
                return 'USER DEPOSIT';
            break; 
            case TransactionStatus::USER_WITHDRAW:
                return 'ADMIN WITHDRAW';
            break;
            case TransactionStatus::ADMIN_WITHDRAW:
                return 'ADMIN WITHDRAW';
            break;
            case TransactionStatus::WALLET_DEPOSIT:
                return 'WALLET DEPOSIT';
            break;
            case TransactionStatus::WALLET_WITHDRAW:
                return 'WALLET WITHDRAW';
            break;
            default:
                return '';
            break;
        }
    }

    const STATUS_VALUE = 1;
    public static function statusMessage($status){
        if($status === TransactionStatus::STATUS_VALUE){
            return 'Successful';
        }else return 'Failed';
    }
}