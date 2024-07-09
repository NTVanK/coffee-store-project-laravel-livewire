<?php

namespace App\Livewire\Layout;

use App\Helper\Cart;
use App\Livewire\App\Layout\CartLayout;
use App\Models\Products;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class ShowProduct extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';
    public $action;

    protected $listeners = ['updateCarts'];

    public function updateCarts()
    {
        $this->render();
    }
    public function mout($action)
    {   
        $this->action = $action ?? null;
    }

    public function addCart($id)
    {
        if(Auth::check())
        {
            (new Cart())->add($id);
            $this->dispatch('updateCarts');
        }
        else
        {
            $this->dispatch('show-toast', ['type' => 'error', 'message' => 'Vui lòng đăng nhập để sử dụng tính năng này!']);
        }
    }

    public function deleteCart($id)
    {
        (new Cart())->delete($id);
        $this->dispatch('updateCarts');
    } 

    public function changePage($key)
    {
        switch ($key) {
            case 'next':
                $this->nextPage();
                break;
            case 'prev':
                $this->previousPage();
                break;
        }
    }
    public function render()
    {
        return view('livewire.layout.show-product',
            [
                'products'=> Products::Paginate(5),
                'carts' => (new Cart())->list()
            ]);
    }
}
