<?php

namespace App\Livewire\App\Auth;

use Livewire\Attributes\Validate;
use Livewire\Component;
use App\Email\SendMail;
use App\Models\Token;
use App\Models\User;
use Illuminate\Support\Carbon;
use DateTimeZone;

class Register extends Component
{
    public $event = 'addEmail';
    #[Validate('email', message:'Vui lòng nhập đúng định dạng email!')]
    #[Validate('unique:users,email', message:'Email này đã tồn tại!')]
    public $email;
    public $showPassword = [
        'type' => 'password',
        'show' => 'fa-eye',
    ];
    public $verifyOTP, $otp;
    public $route;

    public function mount($route)
    {
        if($route == null)
        {
            session()->flash('toast', [
                'type' => 'error',
                'message' => 'Lỗi xử lý đăng nhập!'
            ]);

            return redirect()->route('app.login');
        }

        $this->route = $route == 'register' ? 'app.register.create' : 'app.forgotPassword';
    }

    public function sendOTP($email)
    {
        try
        {
            $otp = rand(100000, 999999);

            $now = Carbon::now();
            $now->setTimezone(new DateTimeZone('Asia/Ho_Chi_Minh'));
            Token::updateOrCreate(
                ['email' => $email],
                [
                    'email' => $email,
                    'otp' => $otp,
                    'created_at' => $now
                ]
            );

            $mailer = new SendMail();
            $mailer->Email($email, 'Mã xác nhận', 'Code - '.$otp);
            $this->dispatch('show-toast', ['type' => 'success', 'message' => 'Email đã gửi thành công!']);
        }
        catch (\Exception $e) 
        {
            $this->dispatch('show-toast', ['type' => 'error', 'message' => 'Email gửi không thành công!' .$e]);
        }
    }

    public function replaySendOTP()
    {
        $validated = $this->validateOnly('email');
        $this->sendOTP($validated['email']);
    }

    public function addEmail()
    {
        $validated = $this->route == 'app.register.create' ? $this->validateOnly('email') : $this->email;

        $this->sendOTP($validated['email'] ?? $validated);
        $this->event = 'verifyEmail';
    } 

    public function verifyEmail()
    {
        $now = Carbon::now();
        $now->setTimezone(new DateTimeZone('Asia/Ho_Chi_Minh'));
        $token = Token::where('email',$this->email)->first();
        if($token->otp == $this->verifyOTP)
        {
            if($this->route == 'app.register.create' )
            {
                User::create([
                    'name' => 'null',
                    'password' => 'null',
                    'email' => $this->email,
                    'email_verified_at' => $now
                ]);
                Token::updateOrCreate(
                    ['email' => $this->email],
                    [
                        'email' => $this->email,
                        'otp' => 'null',
                        'created_at' => $now
                    ]
                );
                return redirect()->route($this->route,['email'=>$token->email]);
            }
            else
            {
                Token::updateOrCreate(
                    ['email' => $this->email],
                    [
                        'email' => $this->email,
                        'otp' => 'null',
                        'created_at' => $now
                    ]
                );
                return redirect()->route($this->route,['email'=>$token->email]);
            }
        }
        $this->dispatch('show-toast', ['type' => 'error', 'message' => 'Kiểm tra không thành công!']);
    }
    public function render()
    {
        return view('livewire.app.auth.register');
    }
}
