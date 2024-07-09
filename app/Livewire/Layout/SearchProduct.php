<?php

namespace App\Livewire\Layout;

use App\Models\Products;
use Livewire\Component;

class SearchProduct extends Component
{
    public $search = '';

    public function render()
    {
        if ($this->search != '') 
        {
            $searchResults = Products::where('name', 'like', '%' . $this->search . '%')
            ->simplePaginate(6);
        }
        return view('livewire.layout.search-product',['searchResults' => $searchResults ?? null]);
    }
}
