<?php

namespace App\Livewire\Admin\User;

use App\Models\Infor;
use App\Models\User as ModalUser;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Livewire\Features\SupportFileUploads\WithFileUploads;

class User extends Component
{
    use WithFileUploads;
    #[Validate('unique:users,name', message: 'Tên người dùng đã tồn tại!')]
    public $name;
    #[Validate(['photo' => 'image|max:2048'])] // 1MB Max
    public $photo;
    #[Validate('numeric|min:10|max:10', message:'Vui lòng nhập số (10 số)!')]
    public $email;
    public $phone;
    public $home_address;
    public $action = false;

    public $search = '';

    public function resetData()
    {
        $this->reset();
    }

    public function show($id)
    {
        $user = Infor::where('id', $id)->first();
        if(!$user)
        {
            return $this->dispatch('show-toats', ['type' => 'error', 'message' => 'Không tìm thấy người dùng này!']);
        }
        $this->email = $user->user->email;
        $this->name = $user->user->name;
        $this->photo = $user->user->img;
        $this->phone = $user->phone ?? '';
        $this->home_address = $user->home_address ?? '';
    }

    public function showEdit()
    {
        $this->action = $this->action ? false : true;
    }

    public function editUser()
    {   
        $user = ModalUser::where('email', $this->email)->first();
        $infor = Infor::where('user_id', $user->id)->first() ?? new Infor();
        
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
                ['id' => $user->id],
                [
                    'name' => $this->name,
                    'img' => $fileF ?? $user->img
                ]
            );

            $infor->updateOrCreate(
                ['user_id' => $user->id],
                [
                    'phone' => $this->phone == '' ? null : $this->phone,
                    'home_address' => $this->home_address == '' ? null : $this->home_address, 
                ]
            );

            if($infor && $user)
            {
                $this->dispatch('show-toast', ['type' => 'success', 'message' => 'Lưu thông tin thành công!']);
                $this->render();
                $this->reset();
            }
        }
        catch(\Exception $e)
        {
            $this->dispatch('show-toast', ['type' => 'error', 'message' => 'Lỗi! '.$e->getMessage()]);
        }
    }

    public function render()
    {
        return view('livewire.admin.user.user',[
            'infors' => Infor::whereHas('user', function ($query) {
                $query->wherenot('is_admin',1)->when($this->search != '', function ($query) {
                    $query->where('name', 'like', '%' . $this->search . '%');
                });
            })->get()
        ]);
    }
}
