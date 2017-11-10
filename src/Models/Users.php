<?php

namespace Pinkwhale\Jellyfish\Models;

use Illuminate\Database\Eloquent\Model;

class Users extends Model
{
    protected $table = 'jelly_users';

    static function User(){
        return (new Users)->where('id',(new Session)->GetSession()->user_id)->firstOrFail();
    }

    static function IsAdmin(){
        return (new Users)->where('id',(new Session)->GetSession()->user_id)->firstOrFail()->rank == 'admin' ? true : false;
    }
}
