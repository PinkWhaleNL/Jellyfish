<?php

namespace Pinkwhale\Jellyfish\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Hash;
use Pinkwhale\Jellyfish\Models\Session;
use Pinkwhale\Jellyfish\Models\Users;
use Validator;

class AuthController extends Controller
{
    public function index(){
        return view('jf::pages.auth.login');
    }

    public function store(){

        $validator = Validator::make(request()->all(),[
            'username' => 'required|email|exists:jelly_users,email',
            'password' => 'required'
        ]);

        // Check standard validation rules. If user exists in DB. Go one.
        if ($validator->fails()) { return back()->withErrors($validator)->withInput(); }

        // Compare password with DB one.
        $user = (new Users)->where('email',request()->username)->first();
        $validator->after(function ($validator) use($user) {
            if(!Hash::check(request()->password,$user->password)){
                $validator->errors()->add('password', 'Password does not match!');
            }
        });

        // If the password check fails.
        if ($validator->fails()) { return back()->withErrors($validator)->withInput(); }

        // Otherwise create Jelly session.
        return (new Session)->CreateJellySession($user);
    }

    public function logout(){
        session()->forget('jelly');
        return redirect()->route('jelly-dashboard');
    }
}
