<?php

namespace Pinkwhale\Jellyfish\Models;

use Illuminate\Database\Eloquent\Model;

class Session extends Model
{
    protected $table = 'jelly_sessions';

    public function CreateJellySession($user){

        // Drop existing jelly session if exists.
        session()->forget('jelly');

        // Create session in DB.
        $session = (new Session);
        $session->user_id = $user->id;
        $session->data = json_encode([

        ]);
        $session->ip = request()->ip();
        $session->browser = request()->header('User-Agent');
        $session->save();
        // Create new session.
        session(['jelly' => $session->id]);

        return redirect()->route('jelly-dashboard');
    }

    public function CheckSession(){
        return (new Session)->where('id',session('jelly'))->where('ip',request()->ip())->where('browser',request()->header('User-Agent'))->first() != null ? true : false;
    }

    public function GetSession(){
        return (new Session)->where('id',session('jelly'))->where('ip',request()->ip())->where('browser',request()->header('User-Agent'))->firstOrFail();
    }
}
