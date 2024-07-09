<?php

namespace App\Livewire\Layout;

use App\Models\Brands;
use Livewire\Component;

class Brand extends Component
{
    public function render()
    {
        return view('livewire.layout.brand',
        ['brands' => Brands::all()]);
    }
}
