<?php
/**
 * Created by PhpStorm.
 * User: Orisatoberu
 * Date: 4/1/2017
 * Time: 12:56 PM
 */

namespace App\Http\Controllers\Bet;


class Bet
{
    public $video_id;

    public $user_id;

    public $user_session;

    public $bet_id;

    public $expiry_date;
    
    public $maximum_view;

    public $odd;

    public $betAmount;

    public $price;

    public function __construct($user_id=null, $bet_id=null, $video_id=null)
    {
        $this->bet_id = $bet_id;
        $this->user_id = $user_id;
        $this->video_id = $video_id;
    }
}