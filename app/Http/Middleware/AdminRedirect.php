<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminRedirect
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check() && Auth::user()->is_admin == 1) {
            return $next($request);
        } else if(Auth::check() && Auth::user()->is_admin == 0) {
            Auth::logout();
            session()->flash('toast', [
                'type' => 'error',
                'message' => 'Không thể đăng nhập bằng tài khoản người dùng!'
            ]);
            return redirect()->route('admin.login');
        }

        return redirect()->route('admin.login');
    }
}
