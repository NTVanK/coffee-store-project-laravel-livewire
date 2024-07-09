<?php

namespace App\Livewire\Admin\Category;

use Illuminate\Support\Str;
use App\Models\Brands;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithPagination;


class Brand extends Component
{
    use WithPagination;
    public $limit = 8;
    public $search = "";
    public $column_name = 'id';
    public $soft = 'desc';
    public $event = 'create';
    public $id;
    public $name;

    public $temp_name;
    public $slug;
    public $is_active = false;

    public function resetData()
    {
        $this->resetValidation();
        $this->event = 'create';
        $this->id = '';
        $this->name = '';
        $this->temp_name = '';
        $this->slug = '';
        $this->is_active = false;
    }

    public function resetTable()
    {
        $this->search = '';
        $this->column_name = 'id';
        $this->soft = 'desc';
    }

    public function getData($id, $event = null)
    {
        $this->resetData();
        $category = Brands::where('id', $id)->first();
        $this->id = $category->id;
        $this->name = $category->name;
        $this->temp_name = $category->name;
        $this->slug = $category->slug;
        $this->is_active = $category->is_active == 1 ? true : false;
        $this->event = $event ? $event : 'create';

    }

    public function changeActive($id) 
    {      
        $data = Brands::where('id', $id)->first();
        $data->is_active =  $data->is_active != 1 ? 1 : 0;
        $data->update();
        $this->resetData();
    }

    public function updateSlug()
    {
        $this->resetValidation();
        $this->slug = '';
        $slug = Str::slug($this->name);
        $valedated = Validator::make(
            ['slug' => $slug],
            ['slug' => Rule::unique('Brands', 'slug')],
            ['unique' => 'Thương hiệu này đã tồn tại!'],
        )->validate();
        $this->slug = $valedated['slug'];
    }

    public function create()
    {
        try
        {
            $data = [
                'name'=> $this->name,
                'slug'=> $this->slug,
                'is_active'=> $this->is_active ? 1 : 0,
            ];

            $category = Brands::create($data);
            if($category)
            {
                $this->resetData();
                $this->dispatch('show-toast', ['type' => 'success', 'message' => '<b class="text-danger">'.$data['name'].'</b> đã được thêm thành công!']);
            }
        } 
        catch (\Exception $e) 
        {
            $this->dispatch('show-toast', ['type' => 'error', 'message' => 'Thêm dữ liệu không thành công!']);
        }
    }

    public function update()
    {
        $slug = Str::slug($this->name);
        Validator::make(
            ['slug' => $slug],
            ['slug' => Rule::unique('Brands', 'slug')],
            ['unique' => 'Thương hiệu này đã tồn tại!'],
        )->validate();
        try
        {
            $category = Brands::findOrFail($this->id);
            $category->name = $this->name;
            $category->slug = $slug;
            $category->is_active = $this->is_active ? 1 : 0;
            if($category->update())
            {
                $this->resetData();
                $this->dispatch('show-toast', ['type' => 'success', 'message' => '<b class="text-danger">'.$category->name.'</b> đã cập nhật thành công!']);
            };
        }
        catch (\Exception $e) 
        {
            $this->dispatch('show-toast', ['type' => 'error', 'message' => 'Cập nhật không thành công!']);
        }
    }

    public function delete($id)
    {
        try
        {
            $data = Brands::find($id);
            $name = $data->name;
            if($data->delete())
            {
                $this->resetData();
                $this->dispatch('show-toast', ['type' => 'success', 'message' => 'Dữ liệu <b>'.$name.'</b> đã được xóa thành công!']);
                $this->dispatch('close-modal');
            }
        }
        catch (\Exception $e)
        {
            $this->dispatch('show-toast', ['type'=> 'error', 'message' => 'Xóa dữ liệu không thành công!']);
        }
    }

    public function gotoPage($page, $number = null)
    {
        switch ($page) 
            {
                case 'Page': 
                    $this->setPage($number); 
                    break;
                case 'Next':
                    $this->nextPage();
                    break;
                case 'Previous': 
                    $this->previousPage();
                    break;
                case 'lastNext': 
                    $this->setPage($this->perPage); 
                    break;
                case 'lastPrevious':
                    $this->setPage(1);
                    break;
                default: $this->dispatch('show-toast', ['type'=> 'error', 'message' => 'Lỗi!']);
            }
    }

    public function searching($column, $soft)
    {

        $this->column_name = $column;
        $this->soft = $this->soft == $soft ? 'asc' : 'desc';
    }

    public function searchResults()
    {
        try
        {
            return Brands::where($this->column_name, 'like', '%' . $this->search . '%')
                            ->orderBy($this->column_name, $this->soft)
                            ->paginate($this->limit);
        }
        catch (\Exception $e)
        {
            $this->dispatch('show-toast', ['type' => 'error', 'message' => 'Dữ liệu tìm kiếm lỗi!']);
        }
    }
    public function render()
    {
        return view('livewire.admin.category.brand',
        [
            'brands' => $this->searchResults(),
        ]);
    }
}
