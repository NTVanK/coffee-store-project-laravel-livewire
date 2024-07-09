<div class="container-fluid mt-3" id=" showComponent ">

    <div wire:ignore.self class="modal fade" id="addModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-hidden="true">
        <form wire:submit.prevent="create" class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-body-tertiary border border-success">
                    <div class="btn-group w-100">
                        <input type="radio" class="btn-check" name="options" id="option1" value="categories"
                            wire:model.live='category' @if ($category == 'categories') checked @endif>
                        <label class="btn btn-outline-success" for="option1" wire:click='closeModal'>Danh mục sản
                            phẩm</label>

                        <input type="radio" class="btn-check" name="options" id="option2" value="brands"
                            wire:model.live='category' @if ($category != 'categories') checked @endif>
                        <label class="btn btn-outline-success" for="option2" wire:click='closeModal'>Thương hiệu sản
                            phẩm</label>
                    </div>
                </div>
                <div class="modal-body border border-success">
                    <label for="category" class="form-label text-success fw-bold">
                        {{ $category == 'categories' ? 'Nhập danh mục sản phẩm' : 'Nhập thương hiệu sản phẩm' }}
                    </label>

                    <input type="text" class="form-control @error('categoruSlug') is-invalid @enderror"
                        wire:model.live="category_name" id='category' required>
                    @error('categoruSlug')
                        <span class="invalid-feedback fw-bold">{{ $message }}</span>
                    @enderror
                </div>
                <div class="modal-footer bg-body-tertiary border border-success">
                    <button type="button" class="btn btn-outline-success" id="closeModal" data-bs-dismiss="modal"
                        wire:click='closeModal'>Đóng</button>
                    <button type="submit" class="btn btn-success">Xác nhận</button>
                </div>
            </div>
        </form>
    </div>

    <hr>


    @if (!$route)
        <form class="container-fluid" action="{{ route('product.store') }}" method="POST" enctype="multipart/form-data">
        @else
            <form class="container-fluid" action="{{ route('product.update', ['product' => $route]) }}" method="POST"
                enctype="multipart/form-data">
                @method('PUT')
    @endif
    @csrf
    <div class="row g-0 rounded border border-dark p-1 bg-white">
        <div class="btn btn-sm btn-dark text-warp col">
            {!! $product ? 'Cập nhật: <b>' . $product->name . '</b>' : 'Thêm sản phẩm' !!}
        </div>

        @livewire('layout.searchProduct')

        <div class="btn-group-sm g-0" style="width: max-content">
            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addModal">
                <i class="fa-soild fa-plus"></i>
                Thêm danh mục
            </button>
            <button href="{{ route('product.create') }}" class="btn btn-sm btn-danger" wire:navigate>
                Xóa dữ liệu
            </button>
            <button type="submit" class="btn btn-sm btn-primary" @if ($errors->any()) disabled @endif>
                {{ $route ? 'Cập nhật dữ liệu' : 'Lưu dữ liệu' }}
            </button>
        </div>

    </div>
    <div class="row g-0 gap-2 mt-2">
        <div class="col form-control text-bg-dark" style="height: max-content">
            <div class="row mt-3">
                <div class="col-sm">
                    <label class="form-label" for="name">Tên sản phẩm</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" wire:model="name"
                        wire:change="updateSlug" name="name" id="name" value="{{ $product->name ?? '' }}"
                        autocomplete="on" required>
                    @error('name')
                        <span class="invalid-feedback fw-bold">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col">
                    <label class="form-label" for="slug">Địa chỉ sản phẩm</label>
                    <input type="text" class="form-control col" wire:model='slug' value="{{ $product->slug ?? '' }}"
                        name="slug" id="slug" readonly>
                </div>
                <div class="col">
                    <label class="form-label" for="price">Giá sản phẩm</label>
                    <input type="number" min="0" step="0.01" class="form-control" id="price"
                        name="price" value="{{ $product->price ?? '' }}" required>
                </div>
            </div>

            <div class="row mt-3">
                <div class="col">
                    <label class="form-label" for="category_id">Danh mục sản phẩm</label>
                    <select class="form-select" aria-label="Default select example" id="category_id"
                        name="category_id">
                        <option selected>- Danh mục -</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}"
                                {{ $product && $product->category_id == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col">
                    <label class="form-label" for="brand_id">Thương hiệu sản phẩm</label>
                    <select class="form-select" aria-label="Default select example" id="brand_id" name="brand_id">
                        <option selected>- Thương hiệu -</option>
                        @foreach ($brands as $brand)
                            <option value="{{ $brand->id }}"
                                {{ $product && $product->brand_id == $brand->id ? 'selected' : '' }}>
                                {{ $brand->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col">
                    <label class="form-label">Đặc tính sản phẩm</label>
                    <div class="w-100 d-flex gap-2">
                        <input type="checkbox" class="btn-check" id="c1" name="is_active" autocomplete="off"
                            @if ($product && $product->is_active == 1) checked @endif>
                        <label class="btn fs-6 fw-bold btn-outline-light" for="c1">Hoạt động</label>

                        <input type="checkbox" class="btn-check" id="c2" name="is_featured"
                            autocomplete="off" @if ($product && $product->is_featured == 1) checked @endif>
                        <label class="btn fs-6 fw-bold btn-outline-light" for="c2">Nổi bật</label>

                        <input type="checkbox" class="btn-check" id="c3" name="is_sale" autocomplete="off"
                            @if ($product && $product->is_sale == 1) checked @endif>
                        <label class="btn fs-6 fw-bold btn-outline-light" for="c3">Doanh số</label>
                    </div>
                </div>
            </div>

            <hr>

            <div class="row">
                <label class="form-label">Mô tả sản phẩm</label>
                <div wire:ignore id="descriptionDiv" class="text-dark"></div>
            </div>
        </div>

        <div class="col-sm-3 p-1 rounded bg-white position-sticky" style="height: max-content">
            <input type="file" wire:model="photos"
                class="form-control btn {{ $errors->has('photos') ? 'btn-danger' : 'btn-dark' }}" name="photos[]"
                accept=".jpg, .png" id='photos' multiple>
            <div wire:loading wire:target="photos">Uploading...</div>
            @error('photos')
                <span class="form-control bg-danger-subtle text-danger fw-bold w-100 my-2 active"
                    disabled>{{ $message }}</span>
            @enderror
            @if (!$errors->has('photos'))
                @if ($photos && count($photos) > 0)
                    <div id="carouselExample" class="carousel slide form-control mt-2" data-bs-ride="carousel" style="height: max-content">
                        <div class="carousel-inner">
                            @foreach ($photos as $index => $photo)
                                <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                                    @if (is_object($photo) && method_exists($photo, 'temporaryUrl'))
                                        <img src="{{ $photo->temporaryUrl() }}" class="d-block mx-auto w-75">
                                    @else
                                        <img src="{{ asset($photo) }}" class="d-block mx-auto w-75">
                                    @endif
                                </div>
                            @endforeach
                        </div>
                        @if (count($photos) > 1)
                            <button class="carousel-control-prev fade btn btn-dark" type="button"
                                data-bs-target="#carouselExample" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Previous</span>
                            </button>
                            <button class="carousel-control-next fade btn btn-dark" type="button"
                                data-bs-target="#carouselExample" data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Next</span>
                            </button>
                        @endif
                    </div>
                @else
                    <div class="form-control bg-light text-center mt-2 py-5" style="height: max-content">
                        <label for="photos" class="mb-0">
                            <span class="d-block mb-2">Chọn ảnh (tối đa: 3 ảnh)</span>
                            <span class="d-block mb-2">Ảnh kích thước không quá 1MB</span>
                            <span class="d-block">Đuôi ảnh .jpg hoặc .png</span>
                        </label>
                    </div>
                @endif
            @endif
        </div>
    </div>
    </form>
</div>

<script>
    function checkEditor() {
        const descriptionDiv = document.querySelector('#descriptionDiv');
        if (descriptionDiv) {
            let editorHTML = `
                <textarea class name="description" id="description" wire:model.lazy="description">
                    {!! $description ?? '' !!}
                </textarea>
            `;
            if (!document.getElementById('description')) {
                descriptionDiv.innerHTML = editorHTML;
            } else {
                descriptionDiv.innerHTML = '';
                descriptionDiv.innerHTML = editorHTML;
            }
        }
        return document.getElementById('description') ? true : false;
    }

    document.addEventListener('livewire:navigated', function() {
        setTimeout(function() {
            if (checkEditor()) {
                ClassicEditor.create(document.querySelector('#description'))
                    .catch(error => {
                        console.error('Lỗi với lớp editor:', error);
                    });
            } else {
                console.error("Không thể tìm thấy id 'descriptionDiv'!");
            }
        }, 100);
    });
</script>
