<?php

namespace App\Livewire\Admin\Statistics;

use App\Models\OrderItems;
use App\Models\Orders;
use Carbon\Carbon;
use Livewire\Component;

class Card extends Component
{
    public function totalMonth()
    {
        $sum = 0;
        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();

        foreach ((new Orders)::whereBetween('created_at', [$startOfMonth, $endOfMonth])->get() as $item) 
        {
            if ($item->payment_status == 'complete' && $item->status == 'complete') 
            {
                $sum = $sum + $item->grand_total;
            }
        }

        return $sum;
    }

    public function profitMonth()
    {
        $sum_profit = 0;
        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();

        $sum_total = Orders::whereBetween('created_at', [$startOfMonth, $endOfMonth])
                    ->where('payment_status', 'complete')
                    ->where('status', 'complete')->sum('grand_total');

        $orderItems = OrderItems::with(['order', 'product.import'])
                        ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
                        ->whereHas('order', function ($query) {
                            $query->where('payment_status', 'complete')
                                ->where('status', 'complete');
                        })
                        ->get();

        foreach ($orderItems as $item) {
            $sum_profit += $item->quantity * $item->product->import->cost;
        }

        return $sum_total - $sum_profit;
    }

    public function totalYear()
    {
        $sum = 0;
        $startOfYear = Carbon::now()->startOfYear();
        $endOfYear = Carbon::now()->endOfYear();

        foreach ((new Orders)::whereBetween('created_at', [$startOfYear, $endOfYear])->get() as $item) 
        {
            if ($item->payment_status == 'complete' && $item->status == 'complete') 
            {
                $sum = $sum + $item->grand_total;
            }
        }

        return $sum;
    }

    public function profitYear()
    {
        $sum_profit = 0;
        $startOfYear = Carbon::now()->startOfYear();
        $endOfYear = Carbon::now()->endOfYear();

        $sum_total = Orders::whereBetween('created_at', [$startOfYear, $endOfYear])
                    ->where('payment_status', 'complete')
                    ->where('status', 'complete')->sum('grand_total');

        $orderItems = OrderItems::with(['order', 'product.import'])
                        ->whereBetween('created_at', [$startOfYear, $endOfYear])
                        ->whereHas('order', function ($query) {
                            $query->where('payment_status', 'complete')
                                ->where('status', 'complete');
                        })
                        ->get();

        foreach ($orderItems as $item) {
            $sum_profit += $item->quantity * $item->product->import->cost;
        }

        return $sum_total - $sum_profit;
    }

    public function selltotalProduct()
    {
        $sum = 0;

        foreach ((new OrderItems())::all() as $item) 
        {
            if ($item->order->payment_status == 'complete' && $item->order->status == 'complete') 
            {
                $sum ++;
            }
        }

        return $sum;
    }

    public function requestConfirm()
    {
        $sum = 0;

        foreach ((new Orders())::all() as $item) 
        {
            if ($item->status == 'no confirm') 
            {
                $sum ++;
            }
        }

        return $sum;
    }

    public function render()
    {
        return view('livewire.admin.statistics.card',
        [
            'totalMonth' => $this->totalMonth(),
            'totalYear' => $this->totalYear(),
            'product' => $this->selltotalProduct(),
            'request' => $this->requestConfirm(),
            'profitMonth' => $this->profitMonth(),
            'profitYear' => $this->profitYear()
        ]);
    }
}
