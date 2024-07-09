<?php

namespace App\Http\Controllers\Admin;

use App\Helper\Cart;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    Public function login()
    {
        return view('admin.auth.login');
    }

    public function logout(Cart $cart)
    {
        $cart->destroy();
        Auth::logout();
        return redirect()->route('admin.login');
    }
}

