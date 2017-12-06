<?php
/**
 * Created by PhpStorm.
 * User: Orisatoberu
 * Date: 3/25/2017
 * Time: 11:50 AM
 */

namespace App\Http\Repositories;


use App\User;

class UserRepository
{
    public function findByUsernameOrCreate($userData){
        return User::firstOrCreate([
           'username'   =>  $userData->nickname,
            'email'     =>  $userData->email
        ]);
    }
}