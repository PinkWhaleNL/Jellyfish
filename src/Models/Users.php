<?php

namespace Pinkwhale\Jellyfish\Models;

use Illuminate\Database\Eloquent\Model;

class Users extends Model
{
    protected $table = 'jelly_users';

    /**
     * @return mixed
     */
    static function User(){
        return (new Users)->where('id',(new Session)->GetSession()->user_id)->firstOrFail();
    }

    /**
     * @return bool
     */
    static function IsAdmin(){
        return (new Users)->where('id',(new Session)->GetSession()->user_id)->firstOrFail()->rank == 'admin' ? true : false;
    }

    /**
     * @return bool
     */
    static function Check(){
        try{
            return ((new Users)->where('id',(new Session)->GetSession()->user_id)->first() != null ? true : false);
        } catch (\Exception $exception){
            return false;
        }

    }
}
