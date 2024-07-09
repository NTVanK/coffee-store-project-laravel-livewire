<?php

namespace App\Livewire\Layout;

use App\Models\Categories;
use Livewire\Component;

class Category extends Component
{
    public function render()
    {
        return view('livewire.layout.category',
        ['categories' => Categories::all()]);
    }
}
