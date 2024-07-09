<?php

namespace App\Livewire\App\Auth;

use App\Models\User;
use Livewire\Attributes\Validate;
use Livewire\Component;

class RegisterCreate extends Component
{
    #[validate('required')]
    public $email;
    #[validate('required')]
    public $username;
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
            $user = User::where('email', $validated['email'])->first();
            if($user)
            {
                $user->updateOrCreate(
                    ['email'=>$validated['email']],
                    [
                        'name' => $validated['username'],
                        'password' => $validated['rePassword']
                    ]
                );

                session()->flash('toast', [
                    'type' => 'success',
                    'message' => 'Đăng kí thành công!<br>Vui lòng đăng nhập lại!'
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
        return  view('livewire.app.auth.register-create');
    }
}
