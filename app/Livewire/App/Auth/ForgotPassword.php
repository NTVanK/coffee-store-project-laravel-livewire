<?php

namespace App\Livewire\App\Auth;

use App\Models\User;
use Livewire\Attributes\Validate;
use Livewire\Component;

class ForgotPassword extends Component
{
    public $email;
    public $name;
    #[Validate('min:8', message: 'Vui lòng nhập mật khẩu từ ( 8-20 ký tự )')]
    #[Validate('max:20', message: 'Vui lòng nhập mật khẩu từ ( 8-20 ký tự )')]
    public $password;
    #[Validate('same:password', message: 'Vui lòng nhập đúng mật khẩu!')]
    public $rePassword;
    public $showPassword = [
        'type' => 'password',
        'show' => 'fa-eye',
    ];

    public  $showRePassword = [
        'type' => 'password',
        'show' => 'fa-eye',
    ];

    public function mout($email)
    {
        $this->email = $email;
    }

    public function show($ojbect)
    {
        $this->$ojbect['type'] = $this->$ojbect['type'] == 'password' ? 'text' : 'password';
        $this->$ojbect['show'] = $this->$ojbect['show'] == 'fa-eye' ? 'fa-eye-slash' : 'fa-eye';
    }

    public function create()
    {
        $validated = $this->validate();
        try
        {
            $user = User::where('email', $this->email)->first();
            if($user)
            {
                $user->updateOrCreate(
                    ['email'=>$this->email],
                    [
                        'password' => $validated['rePassword']
                    ]
                );

                session()->flash('toast', [
                    'type' => 'success',
                    'message' => 'Đặt lại mật khẩu thành công!<br>Vui lòng đăng nhập lại!'
                ]);

                return redirect()->route('app.login');
            }
        }
        catch(\Exception $e)
        {
            $this->dispatch('show-toast', ['type' => 'error', 'message' => 'Đăng kí không thành công!']);
        }
        
    }
    public function render()
    {
        $this->name = User::where('email',$this->email)->first()->name;
        return view('livewire.app.auth.forgot-password');
    }
}
