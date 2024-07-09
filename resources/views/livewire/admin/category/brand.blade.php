<div class="container-fluid mt-3" id='showComponent'>
    <hr>

    <div class="row">
        <div class="col-8">
            <div class="row g-0 gap-2">
                <button type="button" class="btn btn-sm btn-dark col-1">SL: {{count($brands)}}</button>
                <div class="input-group p-0 col">
                    <button class="btn btn-sm btn-dark" type="button">
                        <i class="fa-solid fa-search"></i>
                    </button>
                    <input class="form-control form-control-sm" id="search" type="search" placeholder="Tìm kiếm..."
                        wire:model.live.debounce:150ms="search">
                </div>

                <select class="form-select form-select-sm col" id="column_name" wire:model.live="column_name">
                    <option class="btn btn-dark" disabled>Chọn cột</option>
                    <option value="id" @if ($column_name == 'id') selected @endif>id</option>
                    <option value="name" @if ($column_name == 'name') selected @endif>name</option>
                    <option value="slug" @if ($column_name == 'slug') selected @endif>slug</option>
                    <option value="is_active" @if ($column_name == 'is_active') selected @endif>is_active</option>
                </select>
                <select class="form-select form-select-sm col" id="soft" wire:model.live='soft'>
                    <option class="btn btn-dark" disabled>Chọn sắp xếp</option>
                    <option value="desc" @if ($soft == 'desc') selected @endif>Giảm dần</option>
                    <option value="asc" @if ($soft == 'asc') selected @endif>Tăng dần</option>
                </select>
                <button type="button" class="btn btn-sm btn-primary col" wire:click='resetTable'>
                    <i class="fa-solid fa-arrows-rotate"></i>
                    Làm mới
                </button>
            </div>

            <div class="row g-0 mt-2">
                <table class="table table-striped rounded overflow-hidden table-hover" id='brandTable'>
                    <thead class="table-dark">
                        <tr>
                            <th><button class="btn btn-dark" wire:click="searching('id','desc')">ID</button></th>
                            <th><button class="btn btn-dark" wire:click="searching('name','desc')">Tên</button></th>
                            <th><button class="btn btn-dark" wire:click="searching('slug','desc')">Slug</button></th>
                            <th><button class="btn btn-dark" wire:click="searching('is_active','desc')">Trạng
                                    thái</button></th>
                            <th><button class="btn btn-dark" disabled>Chức năng</button></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($brands as $brand)
                            <tr>
                                <td>{{ $brand->id }}</td>
                                <td>{{ $brand->name }}</td>
                                <td>{{ $brand->slug }}</td>
                                <td>
                                    @if ($brand->is_active == '1')
                                        <button class="btn btn-sm btn-outline-success"
                                            wire:click="changeActive({{ $brand->id }})">on</button>
                                    @else
                                        <button class="btn btn-sm btn-outline-danger"
                                            wire:click="changeActive({{ $brand->id }})">off</button>
                                    @endif
                                </td>
                                <td>
                                    <button wire:click="getData({{ $brand->id }}, 'update')"
                                        class="btn btn-success btn-sm">
                                        Sửa
                                    </button>
                                    <button wire:click="delete({{ $brand->id }})"
                                        wire:confirm='Bạn có muốn xóa {{ $brand->name }} không?'
                                        class="btn btn-danger btn-sm">
                                        Xóa
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-danger fw-bold">Không có dữ liệu nào trong bảng!</td>
                            </tr>
                        @endforelse
                    </tbody>
                    @if ($brands->hasPages())
                        <tfoot class="table-dark">
                            <tr>
                                <th colspan="5">
                                    <div class="d-flex align-items-center justify-content-between py-1">
                                        <button class="btn btn-light">
                                            {{ $brands->currentPage() }} / {{ $brands->lastPage() }} trang
                                            trên
                                            {{ count($brands) }}
                                            sản phẩm
                                        </button>
                                        <nav class="btn-group ms-auto" role="navigation"
                                            aria-label="Pagination Navigation">
                                            <button type="button" class="btn btn-light"
                                                wire:click="gotoPage('lastPrevious')" wire:loading.attr="disabled">
                                                <i class="fa-solid fa-angles-left"></i>
                                            </button>
                                            <button type="button" class="btn btn-light"
                                                wire:click="gotoPage('Previous')" wire:loading.attr="disabled">
                                                <i class="fa-solid fa-angle-left"></i>
                                            </button>
                                            @php
                                                $startPage = max($brands->currentPage() - 1, 1);
                                                $endPage = min($brands->currentPage() + 1, $brands->lastPage());

                                                if ($brands->currentPage() - 1 < 1) {
                                                    $endPage = min(3, $brands->lastPage());
                                                }

                                                if ($brands->currentPage() + 1 > $brands->lastPage()) {
                                                    $startPage = max($brands->lastPage() - 2, 1);
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
                                                @if ($brands->currentPage() < $brands->lastPage()) wire:click="gotoPage('Next')" @endif
                                                wire:loading.attr="disabled">
                                                <i class="fa-solid fa-angle-right"></i>
                                            </button>
                                            <button type="button" class="btn btn-light"
                                                wire:click="gotoPage('Page', {{ $brands->lastPage() }})"
                                                wire:loading.attr="disabled">
                                                <i class="fa-solid fa-angles-right"></i>
                                            </button>
                                        </nav>
                                    </div>
                                </th>
                            </tr>
                        </tfoot>
                    @endif
                </table>
            </div>
        </div>
        <div class="col-4">
            <div class="card shadow">
                <div class="card-header fs-5 fw-bold">
                    {!! $event == 'create'
                        ? 'Thêm thương hiệu sản phẩm'
                        : 'Cập nhật <span class="text-danger">' . ($temp_name ?? '') . '</span>' !!}
                </div>
                <div class="card-body">
                    <label class="form-label fw-bold mt-2" for="name">Tên thương hiệu</label>
                    <input type="text" class="form-control col @error('slug') is-invalid @enderror"
                        wire:model="name" wire:change="updateSlug" id='name' autocomplete="name" required>
                    @error('slug')
                        <div class="invalid-feedback fw-bold">{{ $message }}</div>
                    @enderror
                    <label class="form-label fw-bold mt-2" for="slug">Slug thương hiệu</label>
                    <input type="text" class="form-control col" wire:model="slug" id="slug" readonly>
                    <hr>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="is_active" wire:model="is_active"
                            {{ $is_active ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_active">
                            Trạng thái thương hiệu
                        </label>
                    </div>
                </div>
                <div class="card-footer text-end">
                    <button type="reset" class="btn btn-outline-dark" wire:click='resetData'>Xóa</button>
                    <button type="submit" class="btn btn-dark" wire:click="{{ $event }}">Lưu dữ
                        liệu</button>
                </div>
            </div>
        </div>
    </div>

</div>
