<?php

use App\Helper\Cart;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\App\LoginRegisterController;
use App\Http\Middleware\AdminRedirect;
use App\Http\Middleware\UserRedirect;
use App\Models\Infor;
use App\Models\OrderItems;
use App\Models\Orders;
use App\Models\Products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    echo 'Hello World!';
    echo '<br>{!!<a href="{{ route("home") }}">Trang</a>!!}';
});


Route::middleware('admin')->group(function () {
    Route::prefix('admin')->group(function () {

        Route::get('/loginAdmin', [LoginController::class,'login'])
        ->name('admin.login')
        ->withoutMiddleware([AdminRedirect::class]);

        Route::get('/statistics', function(){
            return view('admin.statistics.statistics');
        })->name('statistics');

        Route::get('/comment', function(){
            return view('admin.comment.comment');
        })->name('admin.comment');

        Route::get('/info-admin', function(){
            return view('admin.auth.admin');
        })->name('admin.info');

        Route::get('/user', function(){
            return view('admin.user.user');
        })->name('admin.user');

        Route::get('/', function () {
            return view('layout.admin');
        })->name('admin');
        Route::get('/category', function(){
            return view('admin.category.category');
        })->name('category.index');
        Route::get('/brand', function(){
            return view('admin.category.brand');
        })->name('brand.index');
        Route::resource('/product', ProductController::class);
        Route::get('/logoutAdmin', [LoginController::class,'logout'])->name('admin.logout');
    });
});

Route::prefix('hydros')->group(function () {

    Route::get('/', function () {
        return view('app.layout.home');
    })->name('home');

    Route::get('/cart', function() {
        return view('app.layout.cart');
    })->middleware('cart')->name('cart');

    Route::get('/payment-check', function(Cart $cart) {
        return view('app.layout.checkPayment',['carts' => $cart]);
    })->middleware('payment-check')->name('payment');

    Route::get('/bill/{id}', function($id, Infor $infor, Orders $order, OrderItems $orderItems) {
        $infor = $infor->where('user_id', Auth::user()->id)->first();
        $order = $order->where('id', $id)->first();
        if($order)
        {
            $orderItems = $orderItems->where('order_id', $order->id)->get();
        }
        return view('app.layout.bill',
            [
                'infor' => $infor,
                'order' => $order,
                'orderItems' => $orderItems
            ]);
    })->middleware('payment-check')->name('bill');

    Route::get('/info', function () {
        return view('app.client.info');
    })->name('user.info');

    Route::get('/order', function () {
        return view('app.client.order');
    })->name('user.order');

    Route::get('/all-product', function () {
        return view('app.layout.allProduct');
    })->name('allproduct');

    Route::get('/detail/{id}', function ($id) {
        return view('app.layout.detail',['id' => $id]);
    })->name('detail');

    Route::middleware('user')->group(function() {
        Route::get('/account', function () {
            return redirect()->route('app.login');
        });
        Route::prefix('account')->group(function () {
            Route::get('/login', [LoginRegisterController::class,'login'])->name('app.login');
            Route::get('/register', [LoginRegisterController::class,'register'])->name('app.register');
            Route::get('/forgotPassword', [LoginRegisterController::class,'forgotPassword'])->name('app.forgotPassword');
            Route::get('/register/create', [LoginRegisterController::class,'registerCreate'])->name('app.register.create');
        });
    });

    Route::get('/logout', [LoginRegisterController::class,'logout'])->name('app.logout');

});



