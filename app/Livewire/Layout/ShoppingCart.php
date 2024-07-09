<?php

namespace App\Livewire\Layout;

use App\Helper\Cart;
use App\Models\Products;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ShoppingCart extends Component
{
    protected $listeners = ['updateCarts'];

    public function updateCarts()
    {
        $this->render();
    }
    public function deleteCart($id)
    {
        (new Cart())->delete($id);
        $this->dispatch('updateCarts');
    }
    public function RedirectCarts()
    {
        
        if(!Auth::check())
        {
            return redirect()->route('app.login');
        }
        else
        {
            return redirect()->route('cart');
        }
    }
    public function render()
    {
        return view('livewire.layout.shopping-cart',
        ['carts' => (new Cart())]);
    }
}
