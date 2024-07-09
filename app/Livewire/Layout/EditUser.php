<?php

namespace App\Livewire\Layout;

use App\Models\Infor;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Livewire\Features\SupportFileUploads\WithFileUploads;

class EditUser extends Component
{
    use WithFileUploads;
    #[Validate('unique:users,name', message: 'Tên người dùng đã tồn tại!')]
    public $name;
    #[Validate(['photo' => 'image|max:2048'])] // 1MB Max
    public $photo;
    #[Validate('numeric|min:10|max:10', message:'Vui lòng nhập số (10 số)!')]
    public $phone;
    public $home_address;
    public $action = false;
    public $alert = false;

    protected $listeners = ['alertInfor'];

    public function alertInfor()
    {
        $this->alert = true;
        $this->render();
    }

    public function mount()
    {
        if(Auth::check())
        {
            $this->name = Auth::user()->name;
            $this->photo = Auth::user()->img ?? 'https://i.pinimg.com/236x/67/57/0b/67570b92b9ed6dc3169845d987cb4c62.jpg';
            $infor = Infor::where('user_id', Auth::user()->id)->first();
            $this->phone = $infor->phone ?? '';
            $this->home_address = $infor->home_address ?? '';
        }
        else
        {
            session()->flash('toast',[
                'type' => 'error',
                'message' => 'Vui lòng đăng nhập!'
            ]);
            return redirect()->route('home');
        }
    }

    public function show()
    {
        $infor = Infor::where('user_id', Auth::user()->id)->first();
        $this->action = $this->action ? false : true;
        if(!$this->action)
        {
            $this->name = Auth::user()->name;
            $this->phone = $infor->phone ?? '';
            $this->home_address = $infor->home_address ?? '';
        }
    }

    public function editUser()
    {   
        $infor = Infor::where('user_id', Auth::user()->id)->first() ?? new Infor();
        $user = User::where('id', Auth::user()->id)->first();
        $folder = public_path('assets/uploads/user');
        $name = Str::slug($this->name);

        try
        {
            if (!file_exists($folder)) {
                mkdir($folder, 0755, true);
            }        
    
            if ($this->photo != $user->img)
            {
                $fileName = $name.'.'.$this->photo->getClientOriginalExtension();
                $filePath = $folder.'/'.$fileName;
    
                if (file_exists($filePath)) {
                    File::delete($filePath);
                }
    
                $this->photo->storeAs('',$fileName);
                $fileF = 'assets/uploads/user/'.$fileName;
            }

            $user->updateOrCreate(
                ['id' => Auth::user()->id],
                [
                    'name' => $this->name,
                    'img' => $fileF ?? Auth::user()->img
                ]
            );

            $infor->updateOrCreate(
                ['user_id' => Auth::user()->id],
                [
                    'phone' => $this->phone == '' ? null : $this->phone,
                    'home_address' => $this->home_address == '' ? null : $this->home_address, 
                ]
            );

            if($infor && $user)
            {
                $this->dispatch('show-toast', ['type' => 'success', 'message' => 'Lưu thông tin thành công!']);
                $this->dispatch('updateCarts');
                $this->action = false;

                if($infor->phone != null && $infor->home_address != null)
                {
                    $this->alert = false;
                }
            }
        }
        catch(\Exception $e)
        {
            $this->dispatch('show-toast', ['type' => 'error', 'message' => 'Lỗi! '.$e->getMessage()]);
        }
    }
    public function render()
    {
        return view('livewire.layout.edit-user');
    }
}
