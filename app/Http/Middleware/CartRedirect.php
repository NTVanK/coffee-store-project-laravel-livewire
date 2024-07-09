<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CartRedirect
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(!Auth::check())
        {
            session()->flash('toast',[
                'type' => 'error',
                'message' => 'Vui lòng đăng nhập để vào tính năng này!'
            ]);

            return redirect()->route('app.login');
        }
        return $next($request);
    }
}
