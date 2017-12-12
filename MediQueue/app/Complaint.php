<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Complaint extends Model
{
    protected $table = 'complaints';

    protected $fillable = ['complaints','status','attend_to','admin_id'];

    protected $hidden = ['password'];

    public function getAdmin($id){
        return User::where('user_id',$id)->first();
    }
}
