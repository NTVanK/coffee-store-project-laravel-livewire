<?php

namespace App\Http\Middleware;

use App\Helper\Cart;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class PaymentCheck
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
                'message' => 'Vui lòng đăng nhập để vào trang thanh toán!'
            ]);
            return redirect()->route('home');
        }

        if(count((new Cart())->list()) == 0)
        {
            session()->flash('toast',[
                'type' => 'error',
                'message' => 'Vui lòng chọn sản phẩm để vào trang thanh toán!'
            ]);
            return redirect()->route('cart');
        }
        return $next($request);
    }
}
