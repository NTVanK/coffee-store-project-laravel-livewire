<?php

namespace App\Livewire\Layout;

use App\Models\Img;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Account extends Component
{
    protected $listeners = ['updateCarts'];

    public function updateCarts()
    {
        $this->render();
    }
    public function render()
    {
        return view('livewire.layout.account');
    }
}
