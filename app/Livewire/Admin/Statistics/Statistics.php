<?php

namespace App\Livewire\Admin\Statistics;

use App\Models\Comments;
use App\Models\OrderItems;
use App\Models\Orders;
use App\Models\Products;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;

class Statistics extends Component
{
    use WithPagination;
    public $date;

    public function totalsForLastFourMonths($date)
    {
        $totals = [];
        $currentDate = Carbon::parse($date);

        for ($i = 0; $i < 4; $i++) {
            $startOfMonth = $currentDate->copy()->subMonths($i)->startOfMonth();
            $endOfMonth = $currentDate->copy()->subMonths($i)->endOfMonth();

            $sum_total = Orders::whereBetween('created_at', [$startOfMonth, $endOfMonth])
                        ->where('payment_status', 'complete')
                        ->where('status', 'complete');

            $sum_profit = 0;

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

            $totals[$startOfMonth->format('Y-m')][0] = $sum_total->sum('grand_total');
            $totals[$startOfMonth->format('Y-m')][1] = $sum_total->sum('grand_total') - $sum_profit;
        }

        return $totals;
    }

    public function render()
    {
        return view('livewire.admin.statistics.statistics',[
            'products' => Products::all(),
            'fiveMonth' => $this->totalsForLastFourMonths($this->date),
            'comments' => Comments::orderBy('created_at', 'desc')->paginate(8)
        ]);
    }
}
