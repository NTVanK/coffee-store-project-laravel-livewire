<?php

namespace App\Livewire\App\Layout;

use App\Helper\Cart;
use App\Models\Products;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Detail extends Component
{
    public $product;
    public $quantity = 1;

    protected $listeners = ['updateCarts'];

    public function mount($id)
    {
        if(!$id)
        {
            session()->flash('toast',[
                'type' => 'error',
                'message' => 'Lỗi không thể xem chi tiết sản phẩm!'
            ]);
            return redirect()->route('home');
        }

        $this->product = Products::where('id', $id)->first();
    }

    public function plus()
    {
        $this->quantity++;
    }

    public function minus()
    {
        if($this->quantity > 1)
        {
            $this->quantity--;
        }
    }

    public function addCart($id)
    {
        if(Auth::check())
        {
            (new Cart())->add($id, $this->quantity);
            $this->quantity = 1;
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

    public function render()
    {
        return view('livewire.app.layout.detail',
        [
            'carts' => (new Cart())->list()
        ]);
    }
}
