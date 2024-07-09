<div class="container-fluid mt-3" id=" showComponent ">
    <hr>

    <div class="row g-0 rounded border border-dark p-1 gap-2">
        <button class="btn btn-sm btn-dark col-1">{{ count($products) }} sản phẩm</button>
        <div class="input-group col">
            <button class="btn btn-sm btn-dark fa-solid fa-search" type="button"></button>
            <input class="form-control form-control-sm" type="search" placeholder="Tìm kiếm..." id="search"
                wire:model.live="search">
        </div>
        <select class="form-select form-select-sm col" id='column_name' wire:model.live="column_name">
            <option class="btn btn-dark" disabled>Chọn cột</option>
            <option value="id" @if ($column_name == 'id') selected @endif>Id</option>
            <option value="category_id" @if ($column_name == 'category_id') selected @endif>Danh mục</option>
            <option value="brand_id" @if ($column_name == 'brand_id') selected @endif>Thương hiệu</option>
            <option value="name" @if ($column_name == 'name') selected @endif>Name</option>
            <option value="is_active" @if ($column_name == 'is_active') selected @endif>Trạng thái</option>
            <option value="is_sale" @if ($column_name == 'is_sale') selected @endif>Doanh số</option>
        </select>
        <select class="form-select form-select-sm col" id="soft" wire:model.live='soft'>
            <option class="btn btn-dark" disabled>Chọn sắp xếp</option>
            <option value="desc" @if ($soft == 'desc') selected @endif>Giảm dần</option>
            <option value="asc" @if ($soft == 'asc') selected @endif>Tăng dần</option>
        </select>
        <a href='{{ route('product.create') }}' wire:navigate type="button" class="btn btn-sm btn-success col">
            <i class="fa-solid fa-plus"></i>
            Thêm sản phẩm
        </a>
        <button type="button" class="btn btn-sm btn-primary col-1" wire:click='resetTable'>
            <i class="fa-solid fa-arrows-rotate"></i>
            Làm mới
        </button>
    </div>

    <div class="row g-0 mt-2">
        <table class="table table-striped rounded overflow-hidden table-hover" id='ProductTable'>
            <thead class="table-dark">
                <tr>
                    <th><button class="btn btn-sm btn-dark" wire:click="searching('id','desc')">ID</button></th>
                    <th><button class="btn btn-sm btn-dark" wire:click="searching('category_id','desc')">Danh
                            mục</button>
                    </th>
                    <th><button class="btn btn-sm btn-dark" wire:click="searching('brand_id','desc')">Thương
                            hiệu</button>
                    </th>
                    <th><button class="btn btn-sm btn-dark" wire:click="searching('name','desc')">Tên</button></th>
                    <th><button class="btn btn-sm btn-dark" disabled>Ảnh</button></th>
                    <th><button class="btn btn-sm btn-dark" wire:click="searching('price','desc')">Giá</button></th>
                    <th><button class="btn btn-sm btn-dark" wire:click="searching('is_active','desc')">Trạng
                            thái</button></th>
                    <th><button class="btn btn-sm btn-dark" wire:click="searching('is_active','desc')">Doanh số</button>
                    </th>
                    <th><button class="btn btn-sm btn-dark" disabled>Chức năng</button></th>
                </tr>
            </thead>
            <tbody>
                @forelse ($products as $product)
                    <tr class="p-1">
                        <td class="fw-bold text-primary p-1">{{ $product->id }}</td>
                        <td class="p-1">{{ $product->category->name }}</td>
                        <td class="p-1">{{ $product->brand->name }}</td>
                        <td class="p-1">{{ $product->name }}</td>
                        <td class="p-1">
                            @if ($product->image)
                                <img src="{{ asset($product->image[0]) }}" width="36" class="rounded">
                            @endif
                        </td>
                        <td class="fw-bold text-danger p-1">{{ $product->price }}</td>
                        <td class="p-1">
                            @if ($product->is_active == '1')
                                <button class="btn btn-sm btn-outline-success"
                                    wire:click="changeActive('is_active',{{ $product->id }})">on</button>
                            @else
                                <button class="btn btn-sm btn-outline-danger"
                                    wire:click="changeActive('is_active',{{ $product->id }})">off</button>
                            @endif
                        </td>
                        <td class="p-1">
                            @if ($product->is_sale == '1')
                                <button class="btn btn-sm btn-outline-success"
                                    wire:click="changeActive('is_sale',{{ $product->id }})">on</button>
                            @else
                                <button class="btn btn-sm btn-outline-danger"
                                    wire:click="changeActive('is_sale',{{ $product->id }})">off</button>
                            @endif
                        </td>
                        <td class="p-1">
                            <div class="btn-group">
                                <a wire:click="showModal({{ $product->id }})" data-bs-toggle="modal"
                                    data-bs-target="#showModal" class="btn btn-warning btn-sm">
                                    Xem
                                </a>
                                <a href="{{ route('product.edit', ['product' => $product->id]) }}" wire:navigate
                                    class="btn btn-success btn-sm">
                                    Sửa
                                </a>
                                <button wire:click="delete({{ $product->id }})"
                                    wire:confirm='Bạn có muốn xóa {{ $product->name }} không?'
                                    class="btn btn-danger btn-sm">
                                    Xóa
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="10" class="text-danger fw-bold">Không có dữ liệu nào trong bảng!</td>
                    </tr>
                @endforelse
            </tbody>

            <tfoot class="table-dark">
                @if ($products->hasPages())
                    <tr>
                        <th colspan="10">
                            <div class="d-flex align-items-center justify-content-between py-1">
                                <button class="btn btn-light">
                                    {{ $products->currentPage() }} / {{ $perPage }} trang trên
                                    {{ $products->total() }}
                                    sản phẩm
                                </button>
                                <nav class="btn-group ms-auto" role="navigation" aria-label="Pagination Navigation">
                                    <button type="button" class="btn btn-light" wire:click="gotoPage('lastPrevious')"
                                        wire:loading.attr="disabled">
                                        <i class="fa-solid fa-angles-left"></i>
                                    </button>
                                    <button type="button" class="btn btn-light" wire:click="gotoPage('Previous')"
                                        wire:loading.attr="disabled">
                                        <i class="fa-solid fa-angle-left"></i>
                                    </button>
                                    @php
                                        $startPage = max($products->currentPage() - 1, 1);
                                        $endPage = min($products->currentPage() + 1, $products->lastPage());

                                        if ($products->currentPage() - 1 < 1) {
                                            $endPage = min(3, $products->lastPage());
                                        }

                                        if ($products->currentPage() + 1 > $products->lastPage()) {
                                            $startPage = max($products->lastPage() - 2, 1);
                                        }
                                    @endphp
                                    @for ($i = $startPage; $i <= $endPage; $i++)
                                        <button type="button" class="btn btn-light"
                                            wire:click="gotoPage('Page', {{ $i }})"
                                            wire:loading.attr="disabled">
                                            {{ $i }}
                                        </button>
                                    @endfor
                                    <button type="button" class="btn btn-light"
                                        @if ($products->currentPage() < $products->lastPage()) wire:click="gotoPage('Next')" @endif
                                        wire:loading.attr="disabled">
                                        <i class="fa-solid fa-angle-right"></i>
                                    </button>
                                    <button type="button" class="btn btn-light" wire:click="gotoPage('lastNext')"
                                        wire:loading.attr="disabled">
                                        <i class="fa-solid fa-angles-right"></i>
                                    </button>
                                </nav>
                            </div>
                        </th>
                    </tr>
                @endif
            </tfoot>

        </table>
    </div>

    @if ($productShow)
        <hr>
        <div class="container-fluid mt-2" wire:transition>
            <div class="row rounded border border-dark p-1 g-0 mb-3">
                <h1 class="modal-title fs-4 fw-bolder col" id="staticBackdropLabel">Xem thông tin sản phẩm</h1>
                <a href="{{ route('product.edit', ['product' => $productShow->id ?? '']) }}"
                    class="btn btn-sm btn-success fw-bolder col-1 ms-auto">Sửa thông tin</a>
                <button type="button" class="btn btn-sm btn-secondary ms-2 fw-bolder col-1" id="showClose"
                    data-bs-dismiss="modal" wire:click="resetProductData">Đóng</button>
            </div>

            <div class="row g-0">
                <div class="col-md-4">
                    <h5 class="text-bg-primary rounded p-3 mb-2" style="width: 100%;">
                        {{ $productShow->name ?? '' }}
                    </h5>
                    @isset($productShow->image)
                        <div id="carouselExample" class="carousel slide form-control mb-2 shadow" data-bs-ride="carousel"
                            style="height: max-content">
                            <div class="carousel-inner">

                                @foreach ($productShow->image as $key => $img)
                                    <div class="carousel-item {{ $key == 0 ? 'active' : null }}">
                                        <img src="{{ asset($img) }}" class="d-block mx-auto w-75">
                                    </div>
                                @endforeach

                            </div>
                            @if ($productShow->image[1] != null)
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
                    @endisset
                    <h3 class="text-bg-danger rounded p-3">
                        {{ $productShow->price ?? '' }} (VND)
                    </h3>
                </div>
                <div class="col-md-8 gap-2 bg-light rounded border border-primary">
                    <b>Loại sản phẩm: </b> {{ $productShow->category->name ?? '' }}
                    <br>
                    <b>Thương hiệu:</b> {{ $productShow->brand->name ?? '' }}</b>
                    <br>
                    <b>Ngày tạo: {{ $productShow->created_at ?? '' }}</b>
                    <br>
                    <b>Ngày cập nhật mới: {{ $productShow->created_at ?? '' }}</b>
                    <br>
                    {!! $productShow->description ?? '' !!}
                </div>
            </div>
        </div>
    @endif
</div>
