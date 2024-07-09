<?php

namespace App\Livewire\App\Layout;

use App\Helper\Cart;
use Livewire\Component;

class CartLayout extends Component
{
    protected $listeners = ['updateCarts'];

    public function updateCarts()
    {
        $this->render();
    }
    public function increase($id)
    {
        $carts = new Cart();
        $carts = $carts->list();
        if($carts[$id])
        {
            $quantity = $carts[$id]['quantity'] + 1;
            (new Cart())->updateQuantity($id, $quantity);
            $this->dispatch('updateCarts');
        }
    }

    public function decrease($id)
    {
        $carts = new Cart();
        $carts = $carts->list();
        if($carts[$id] && $carts[$id]['quantity'] > 1)
        {
            $quantity = $carts[$id]['quantity'] - 1;
            (new Cart())->updateQuantity($id, $quantity);
            $this->dispatch('updateCarts');
        }
    }

    public function delete($id)
    {
        $carts = new Cart();
        $carts = $carts->list();
        if($carts[$id])
        {
            (new Cart())->delete($id);
            $this->dispatch('updateCarts');
        }
    }

    public function destroy()
    {
        (new Cart())->destroy();
        $this->dispatch('updateCarts');
    }
    public function render()
    {
        return view('livewire.app.layout.cart-layout',
        ['carts' => (new Cart())]);
    }
}
