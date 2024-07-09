<?php

namespace App\Http\Controllers\App;

use App\Helper\Cart;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginRegisterController extends Controller
{
    public function login()
    {
        return view('app.auth.login');
    }

    public function logout(Cart $cart)
    {
        $cart->destroy();
        Auth::logout();
        return redirect()->route('home');
    }

    public function register(Request $request)
    {
        return view('app.auth.register',['route' => $request->route]);
    }

    public function registerCreate(Request $request)
    {
        return ($request->email == null) ? 
        redirect()->route('app.register',['route' => 'register']) : 
        view('app.auth.registerCreate', ['email' => $request->email]);
    }

    public function forgotPassword(Request $request)
    {
        return ($request->email == null) ? 
        redirect()->route('app.register',['route' => 'forgotPassword']) : 
        view('app.auth.forgotPassword', ['email' => $request->email]);
    }
}
