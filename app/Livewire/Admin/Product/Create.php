<?php

namespace App\Livewire\Admin\Product;

use App\Models\Brands;
use App\Models\Categories;
use App\Models\Products;
use Illuminate\Support\Facades\Validator;
use Livewire\Attributes\Validate;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;

class Create extends Component
{
    use WithFileUploads;
    #[Validate(['photos.*' => 'mimes:png,jpeg,jpg|max:2048'])]
    #[Validate(['photos' => 'max:3'], message: 'Giới hạn 3 file')]
    public $photos = [];
    public $product;
    public $category = 'categories';
    // #[Validate]
    public $category_name;
    public $route;
    public $name;
    public $slug;
    public $description;

    public function mount($editId = null)
    {
        if ($editId != null) {
            $this->product = Products::findOrFail($editId);
            $this->route = $this->product->id;
            $this->name = $this->product->name;
            $this->slug = $this->product->slug;
            foreach($this->product->image as $key => $image) {
                $this->photos[$key] = $image;
            }
            $this->description = $this->product->description;
        }
    }

    public function closeModal()
    {
        $this->resetValidation('categoruSlug');
        $this->category_name = '';
    }

    public function create()
    {
        Validator::make(
            ['categoruSlug' => Str::slug($this->category_name)],
            ['categoruSlug' => Rule::unique($this->category, 'slug')],
            ['unique' => ($this->category == 'categories') ? 'Tên danh mục này tồn tại!' : 'Tên thương hiệu này đã tồn tại!'],
        )->validate();
        try
        {
            $data = [
                'name'=> $this->category_name,
                'slug'=> Str::slug($this->category_name),
                'is_active' => 1
            ];
            $this->category == 'categories' ? Categories::create( $data ) : Brands::create( $data );
            $this->dispatch('show-toast', ['type' => 'success', 'message' => '<b class="text-danger">'.$this->category_name.'</b> đã được thêm thành công!']);
            $this->dispatch('close-modal');
            $this->closeModal();
        }
        catch (\Exception $e)
        {
            $this->dispatch('show-toast', ['type' => 'error', 'message' => 'Dữ liệu lưu không thành công!']);
        }
    }

    public function updateSlug()
    {
        $this->resetValidation('slug');
        $this->slug = '';
        $slug = Str::slug($this->name);
        Validator::make(
            ['slug' => $slug],
            ['slug' => Rule::unique('products', 'slug')],
            ['unique' => ($this->category == 'categories') ? 'Tên danh mục này tồn tại!' : 'Tên thương hiệu này đã tồn tại!'],
        )->validate();
        $this->slug = $slug;
    }
    public function render()
    {
        return view('livewire.admin.product.create',
        [
            'categories' => Categories::all(),
            'brands' => Brands::all(),
        ]);
    }
}
