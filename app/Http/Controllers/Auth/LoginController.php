<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = RouteServiceProvider::HOME;

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function username()
    {
        return 'username';
    }

//    protected function authenticated(Request $request, $user)
//    {
//        // storeman
//        if ($user->role->slug == 'storeman') {
//            return redirect()->route('movements.index');
//        }
//
//        // other users
//        else {
//            return redirect()->route('home');
//        }
//    }
}
