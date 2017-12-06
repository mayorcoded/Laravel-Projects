<?php
/**
 * Created by PhpStorm.
 * User: Orisatoberu
 * Date: 4/2/2017
 * Time: 4:49 PM
 */

namespace App\Http\Statuses;


class BetStatus
{
    const WIN = 1;
    const LOSE = 2;
    const ONGOING = 0;

    public static function status($status){
        switch ($status){
            case self::WIN:
                return 'win';
                break;
            case self::LOSE:
                return 'lose';
                break;
            case self::ONGOING:
                return 'ongoing';
                break;
            default:
                return '';
                break;
        }
    }
}