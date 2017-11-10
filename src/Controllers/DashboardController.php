<?php

namespace Pinkwhale\Jellyfish\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Hash;
use Pinkwhale\Jellyfish\Models\Session;
use Pinkwhale\Jellyfish\Models\Users;
use Validator;
use JellyAuth;

class DashboardController extends Controller
{
    public function show(){

        return view('jf::pages.dashboard');
    }

}
