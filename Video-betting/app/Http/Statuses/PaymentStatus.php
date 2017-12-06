<?php
/**
 * Created by PhpStorm.
 * User: Orisatoberu
 * Date: 4/2/2017
 * Time: 4:36 PM
 */

namespace App\Http\Statuses;


class PaymentStatus
{
    const PAID = 1;
    const UNPAID = 0;
    const RETURNED = 2;

    public static function status($status=self::PAID){
        $status = strtolower($status);
        switch ($status){
            case self::PAID :
                return 'paid';
                break;
            case self::UNPAID :
                return 'unpaid';
                break;
            case self::RETURNED :
                return 'returned';
                break;
            default:
                return '';
                break;
        }
    }

}