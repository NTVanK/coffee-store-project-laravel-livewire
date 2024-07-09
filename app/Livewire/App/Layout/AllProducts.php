<?php

namespace App\Livewire\App\Layout;

use App\Models\Brands;
use App\Models\Categories;
use App\Models\Products;
use Livewire\Component;

class AllProducts extends Component
{
    public $category, $brand, $star;
    public $rangeLeft = 0, $rangeRight = 0;
    public $search = '';

    public function resetData()
    {
        $this->reset();
    }

    public function searching()
    {
        $products = Products::query()
            ->when($this->search != '', function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%');
            })
            ->when($this->category, function ($query) {
                $query->where('category_id', $this->category);
            })
            ->when($this->brand, function ($query) {
                $query->where('brand_id', $this->brand);
            })
            ->when($this->star, function ($query) {
                $query->whereHas('comments', function ($query) {
                    $query->havingRaw('CEIL(AVG(star)) = ?', [$this->star]);
                });
            })
            ->when($this->rangeLeft >= 0 && $this->rangeRight > 0 && $this->rangeRight > $this->rangeLeft, function ($query) {
                $query->whereBetween('price', [$this->rangeLeft * 50000, $this->rangeRight * 50000]);
            })
            ->get();

        return $products;
    }
    public function render()
    {
        return view('livewire.app.layout.all-products',
        [
            'products' => $this->searching(),
            'categories' => Categories::all(),
            'brands' => Brands::all()
        ]);
    }
}
