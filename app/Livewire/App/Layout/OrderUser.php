<?php

namespace App\Livewire\App\Layout;

use App\Models\OrderItems;
use App\Models\Orders;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class OrderUser extends Component
{
    public $items,$order;
    public function resetData()
    {
        $this->reset();
    }

    public function show($id)
    {
        $this->order = Orders::where('id', $id)->first();
        $this->items = OrderItems::where('order_id', $id)->get();
    }

    public function removeItems()
    {
        $this->items = [];
        $this->order = null;
    }
    public function cancel($id)
    {
        try
        {
            $order = Orders::where('id', $id)->first();
            $updated = $order->update(['status' => 'cancel']);

            if ($updated) {
                $order->refresh();
                if ($order->status == 'cancel') {
                    $this->dispatch('show-toast', ['type' => 'error', 'message' => 'Hủy thành công!']);
                }
            }

        }
        catch(\Exception $e)
        {
            $this->dispatch('show-toast', ['type' => 'error', 'message' => 'Lỗi!'.$e->getMessage()]);
        }
        
    }
    public function render()
    {
        return view('livewire.app.layout.order-user',
        [
            'orders' => Orders::where('user_id', Auth::user()->id)->get(),
            'showItems' => $this->items,
            'orderTitle' => $this->order
        ]);
    }
}
