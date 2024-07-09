<?php

namespace App\Livewire\Layout;

use App\Helper\Cart;
use App\Models\Infor;
use App\Models\OrderItems;
use App\Models\Orders;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class EditPayment extends Component
{
    public $payment;

    public $note;

    public function paymentChange($method)
    {
        $this->payment = $method;
    }

    public function order()
    {
        $infor = Infor::where('user_id', Auth::user()->id)->first();
        $order = new Orders();
        $order_item = new OrderItems();
        $cart = new Cart();

        if($infor == null || $infor == null)
        {
            $this->dispatch('alertInfor');
            return $this->dispatch('show-toast',['type' => 'errer', 'message' => 'Vui lòng nhập thông tin cá nhân!']);
        }

        if($this->payment == 'vnpay' || $this->payment == 'direct')
        {
            try
            {
                $order = $order->create(
                    [
                        'user_id' => Auth::user()->id,
                        'grand_total' => $cart->totalItems(),
                        'payment_method' => $this->payment,
                        'payment_status' => 'waite',
                        'status' => 'no confirm',
                        'currency' => 'VND',
                        'shipping_amout' => ($cart->totalItems() * 0.01),
                        'shipping_method'=> 'fast',
                        'notes' => $this->note ?? ''
                    ]
                );

                if($order->user_id == Auth::user()->id)
                {
                    foreach($cart->list() as $item)
                    {
                        $order_item->create([
                            'order_id' => $order->id,
                            'product_id' => $item['id'],
                            'quantity' => $item['quantity'],
                            'unit_amount'=>$item['price'],
                            'total_amount'=>$item['quantity']*$item['price'],
                        ]);
                    }

                    session()->flash('toast',
                    [
                        'type' => 'success',
                        'message' => 'Đặt hàng thành công!',
                    ]);
                    return redirect()->route('bill', ['id' => $order->id]);
                }
            }
            catch(\Exception $e)
            {
                return $this->dispatch('show-toast',['type' => 'errer', 'message' => 'Lỗi! '.$e->getMessage()]);
            }
        }

        return $this->dispatch('show-toast',['type' => 'errer', 'message' => 'Vui lòng chọn phương thức thanh toán!']);
    }
    public function render()
    {
        return view('livewire.layout.edit-payment',
        ['carts' => (new Cart())]);
    }
}
