<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Imports;
use App\Models\Products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use PHPMailer\PHPMailer\Exception;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view("admin.product.index");
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("admin.product.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try
        {
            $folder = public_path('assets/uploads') . "/" . $request->slug;
            
            if (!file_exists($folder)) {
                mkdir($folder, 0755, true);
            }

            if ($request->hasFile('photos')) {
                $files = [];
                foreach ($request->file('photos') as $key => $file) {
                    $fileName = $request->slug . $key . '.' . $file->getClientOriginalExtension();
                    $file->move($folder, $fileName);
                    $files[$key] = 'assets/uploads/'. $request->slug . '/' . $fileName;
                }
            }

            $import = Imports::create([
                'quantity' => '100',
                'cost' => $request->price / 100 * 75
            ]);
            
            if($import)
            {
                $product = Products::create([
                    'category_id' => $request->category_id,
                    'brand_id' => $request->brand_id,
                    'import_id' => $import->id,
                    'name' => $request->name,
                    'slug' => $request->slug,
                    'image' => $files,
                    'description' => $request->description,
                    'price' => $request->price,
                    'is_active' => $request->is_active == 'on' ? 1 : 0,
                    'is_featured' => $request->is_featured == 'on' ? 1 : 0,
                    'is_stock',
                    'is_sale' => $request->is_sale == 'on' ? 1 : 0,
                ]);

                if($product){
                    session()->flash('toast', [
                        'type' => 'success',
                        'message' => 'Thêm thành công sản phẩm!'
                    ]);

                    return redirect()->route('product.index');
                }
            }
        } catch (\Exception $e) {
            session()->flash('toast', [
                'type' => 'error',
                'message' => $e->getMessage()
            ]);
        }
        
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $id)
    {
        return view("admin.product.create", ["id" => $id]);
    }

    /**
     * Update the specified resource in storage.
     */

    public function FilesPath($new, $old, $photos = null)
    {
        try
        {
            $newFolderPath = public_path('assets/uploads') . "/" . $new;
            $oldFolderPath = public_path('assets/uploads') . "/" . $old;
    
            $files = [];
            $imgs = $photos ?? File::files($oldFolderPath);

            if($photos)
            {
                // Xóa thư mục cũ và tạo thư mục mới
                File::deleteDirectory($oldFolderPath);
                File::makeDirectory($newFolderPath);
    
                foreach ($imgs as $key => $file) {
                    $extension = pathinfo($file->getClientOriginalName(), PATHINFO_EXTENSION);
                    $name = $new . $key . '.' . $extension;
                    $file->move($newFolderPath, $name);
                    $files[] = 'assets/uploads/'. $new . '/' . $name;
                }
            }
            else
            {
                foreach ($imgs as $key => $file)
                {
                    $extension = pathinfo($file, PATHINFO_EXTENSION);
                    $name = $new . $key . '.' . $extension;
                    $name_file_new = $oldFolderPath.'/'.$name;

                    rename($file, $name_file_new);
                    $files[] = 'assets/uploads/'. $new . '/' . $name;
                }

                rename($oldFolderPath, $newFolderPath);
            }
    
            return $files;
        }
        catch (\Exception $e)
        {
            session()->flash('toast', [
                'type' => 'error',
                'message' => $e->getMessage()
            ]);
    
            return redirect()->back();
        }
    }

    public function update(Request $request, string $id)
    {
        try
        {
            $product = Products::where('id', $id)->first();

            if (!$product) {
                session()->flash('toast', [
                    'type' => 'error',
                    'message' => 'Không tìm thấy sản phẩm'
                ]);
                return redirect()->back();
            }

            $product->update([
                'category_id' => $request->category_id,
                'brand_id' => $request->brand_id,
                'name' => $request->name,
                'slug' => $request->slug,
                // 'image' => ($request->hasFile('photos')) ? $this->updateFolder($request->slug, $product->slug, $request->file('photos')) : $this->renameFolder($request->slug, $product->slug),
                'image' => $this->FilesPath($request->slug, $product->slug, $request->file('photos') ?? null),
                'description' => $request->description,
                'price' => $request->price,
                'is_active' => $request->has('is_active') ? 1 : 0,
                'is_featured' => $request->has('is_featured') ? 1 : 0,
                'is_stock' => $request->has('is_stock') ? 1 : 0,
                'is_sale' => $request->has('is_sale') ? 1 : 0,
            ]);
        
            session()->flash('toast', [
                'type' => 'success',
                'message' => '<b class="text-danger">'.$product->name.'</b> đã cập nhật thành công!'
            ]);
        
            return redirect()->route('product.index');
        } catch (\Exception $e) {
            session()->flash('toast', [
                'type' => 'error',
                'message' => $e->getMessage()
            ]);

            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
