<?php

namespace App\Livewire\Admin\Auth;

use App\Models\Img;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Validate;
use Livewire\Component;

use function PHPSTORM_META\type;

class Login extends Component
{
    #[Validate('email', message: 'Vui lòng nhập đúng định dạng Email!')]
    public $email;
    #[Validate('min:8', message: 'Vui lòng nhập mật khẩu từ ( 8-20 ký tự )')]
    #[Validate('max:20', message: 'Vui lòng nhập mật khẩu từ ( 8-20 ký tự )')]
    public $password;
    public $showPassword = [
        'type' => 'password',
        'show' => 'fa-eye',
    ];

    public function show()
    {
        $this->showPassword['type'] = $this->showPassword['type'] == 'password' ? 'text' : 'password';
        $this->showPassword['show'] = $this->showPassword['show'] == 'fa-eye' ? 'fa-eye-slash' : 'fa-eye';
    }

    public function authencate()
    {
        $this->resetValidation();
        $validated = $this->validate();
        if(Auth::attempt(['email' => $validated['email'], 'password' => $validated['password'], 'is_admin' => 1]))
        {
            return redirect()->route('admin');
        }

        $this->dispatch('show-toast', ['type' => 'error', 'message' => 'Đăng nhập không thành công!']);
    }
    public function render()
    {
        return view('livewire.admin.auth.login');
    }
}
