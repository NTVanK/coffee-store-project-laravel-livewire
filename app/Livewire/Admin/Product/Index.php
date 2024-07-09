<?php

namespace App\Livewire\Admin\Product;

use App\Models\Products;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $limit = 7;
    public $search = "";
    public $column_name = 'id';
    public $soft = 'desc';

    public $productShow;

    public function resetTable()
    {
        $this->search = '';
        $this->column_name = 'id';
        $this->soft = 'desc';
    }

    public function showModal($id)
    {
        try
        {
            $product = Products::where('id', $id)->first();
            if($product)
            {
                $this->productShow = $product;
            }
        }
        catch (\Exception $e)
        {
            $this->dispatch('show-toast', ['type' => 'error', 'message' => 'lỗi! Không thể xem được sản phẩm!']);
        }
    }

    public function resetProductData()
    {
        $this->productShow = null;
    }

    public function deleteFolder($dir) {

        if(file_exists($dir))
        {
            $files = glob($dir.'/*');
            foreach($files as $file){
                if(is_file($file))
                unlink($file);
            }
            rmdir($dir);
            return true;
        }
        
        return false;
    }
    

    public function delete($id)
    {
        try
        {
            $product = Products::where('id', $id)->first();

            $name = $product->name;
            $folder = public_path('assets/uploads') . "/" . $product->slug;

            if ($this->deleteFolder($folder)) {
                $product->delete();
                $this->resetProductData();
                $this->dispatch('show-toast', ['type' => 'success', 'message' => 'Dữ liệu <b>'.$name.'</b> đã được xóa thành công!']);
                $this->dispatch('close-modal');
            }
        }
        catch (\Exception $e)
        {
            $this->dispatch('show-toast', ['type' => 'error', 'message' => 'lỗi! Không thể xóa được sản phẩm!']);
        }
    }

    public function changeActive($column, $id)
    {
        try
        {
            $product = Products::where('id', $id)->first();
            if($product)
            {
                $product->$column = $product->$column == 1 ? 0 : 1;
                $product->save();
            }
        }
        catch (\Exception $e)
        {
            $this->dispatch('show-toast', ['type' => 'error', 'message' => 'lỗi! Không thể cập nhật trạng thái sản phẩm!']);
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
            return Products::where($this->column_name, 'like', '%' . $this->search . '%')
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
        return view('livewire.admin.product.index',
        [
            'products'=> $this->searchResults()
        ]);
    }
}
