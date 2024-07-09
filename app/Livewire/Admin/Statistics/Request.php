<?php

namespace App\Livewire\Admin\Statistics;

use App\Models\OrderItems;
use App\Models\Orders;
use Carbon\Carbon;
use Livewire\Component;

class Request extends Component
{
    public $limit = 5;
    public $event = '';

    public $before,$after,$search;
    public $title = [
        'no confirm' => 'Sản phẩm cần duyệt',
        'confirm' => 'Sản phẩm đã duyệt',
        '' => 'Tất cả hóa đơn'
    ];

    public $items,$order;

    public function Event($event)
    {
        $this->event = $event;
    }

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

    public function confirm($id)
    {
        $order = Orders::where('id', $id)->first();
        $order->update([
            'status' => 'confirm'
        ]);
    }

    public function payment($id)
    {
        $order = Orders::where('id', $id)->first();
        $order->update([
            'payment_status' => $order->payment_status == 'waite' ? 'complete' : 'waite',
            'status' => $order->status == 'confirm' ? 'complete' : 'confirm'
        ]);
    }

    public function searching()
    {
        $before = $this->before ? Carbon::parse($this->before) : null;
        $after = $this->after ? Carbon::parse($this->after)->endOfDay() : null;

        return Orders::when($before && $after, function ($query) use ($before, $after) {
            return $query->whereBetween('created_at', [$before, $after]);
        })
        ->with('user')
        ->when($this->search, function ($query, $search) {
            return $query->whereHas('user', function ($query) use ($search) {
                $query->where('name', 'like', "%$search%");
            });
        })
        ->when($this->event, function ($query) {
            return $query->where('status', $this->event);
        })
        ->paginate($this->limit);
    }

    public function render()
    {
        return view('livewire.admin.statistics.request',
        [
            'requestNoConfirm' => $this->searching(),
            'showItems' => $this->items,
            'orderTitle' => $this->order
        ]);
    }

    public function rendered()
    {
        if($this->items)
        {
            $this->dispatch('endPage');
        }
    }
}
