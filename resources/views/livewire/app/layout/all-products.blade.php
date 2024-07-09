<div class="container">
    <h2>Tất cả sản phẩm</h2>
    <div class="form-control sticky-top z-2 header">
        <div class="header-controller">
            <button type="button" class="btn btn-primary" wire:click='resetData'>
                <i class="fa-solid fa-repeat"></i>
            </button>
            <select class="form-select border-dark" wire:model.live='category' aria-label="Default select example">
                <option value="" selected>Danh mục</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
            <select class="form-select border-dark" wire:model.live='brand' aria-label="Default select example">
                <option value="" selected>Thương hiệu</option>
                @foreach ($brands as $brand)
                    <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                @endforeach
            </select>
            <select class="form-select border-dark" wire:model.live='star' aria-label="Default select example">
                <option value="0" selected>Đánh giá</option>
                @for($i = 5; $i >= 1; $i--)
                    <option class="text-bg-warning d-flex" value="{{ $i }}">
                        {{ $i }} sao
                    </option>
                @endfor
            </select>
            <div class="input-group">
                <button type="button" class="btn btn-dark">
                    <i class="fa-solid fa-search"></i>
                </button>
                <input type="search" class="form-control border-dark" wire:model.live='search' id="search"
                    placeholder="Tìm kiếm...">
            </div>
        </div>
        <div class="header-controller mt-1  ">
            <div class="me-2">
                <label for="customRange3" class="form-label">
                    <b>Mệnh giá từ: </b>
                    {{ $rangeLeft * 50000 }} (VND)
                </label>
                <input type="range" class="form-range" wire:model.live='rangeLeft' min="0" max="15" step="0.5" id="customRange3">
            </div>

            <div class="me-2">
                <label for="customRange3" class="form-label">
                    <b>Mệnh giá đến: </b>
                    {{ $rangeRight * 50000 }} (VND)
                </label>
                <input type="range" class="form-range" wire:model.live='rangeRight' min="0" max="15" step="0.5" id="customRange3">
            </div>
        </div>
    </div>
    <hr>
    <div class="form-control">

        <div class="p-content">
            @forelse ($products as $product)
                <div class="card p-card">
                    <button class="btn bg-danger-subtle text-danger p-top active">
                        New
                    </button>
                    <img class="card-img-top" src="{{ asset($product->image[0]) }}" alt="..."
                        onclick="javascript:location.href='{{ route('detail', ['id' => $product->id]) }}'" />
                    <div class="card-body">
                        <div class="d-flex gap-2 prominent">
                            <span class="badge bg-danger-subtle text-danger">
                                <i class="fa-solid fa-thumbs-up fa-sm"></i>
                                Top deal
                            </span>
                            <span class="badge bg-primary-subtle text-primary">
                                <i class="fa-solid fa-square-check fa-sm"></i>
                                Chính hãng
                            </span>
                        </div>
                        <div class="pro-brand mt-1">{{ $product->brand->name ?? 'null' }}</div>
                        <div class="pro-name">{{ $product->name }}</div>
                        <b class="text-danger mt-auto">{{$product->price}} (VND)</b>
                        <div class="pro-evaluate ">
                            <div class="pro-star">
                                @for ($j = 1; $j <= $product->comment(); $j++)
                                    <i class="fa-solid fa-star fa-sm"></i>
                                @endfor
                                @for ($j = 1; $j <= 5 - $product->comment(); $j++)
                                    <i class="fa-regular fa-star fa-sm"></i>
                                @endfor
                            </div>
                            <div class="vr"></div>
                            <div class="">Đã bán: 1.8K</div>
                        </div>
                        <div class="d-flex mt-2 btn-control ">
                            @if (isset($carts[$product->id]) && $carts[$product->id]['id'] == $product->id)
                                <button type="button" class="btn action" wire:click='deleteCart({{ $product->id }})'>
                                    <i class="fa-solid fa-cart-arrow-down me-1"></i>
                                    Đã thêm
                                </button>
                            @else
                                <button type="button" class="btn" wire:click='addCart({{ $product->id }})'>
                                    <i class="fa-solid fa-cart-arrow-down me-1"></i>
                                    Thêm giỏ hàng
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <span class="text-danger fw-bold">Không có sản phẩm nào!</span>
            @endforelse
        </div>

    </div>


    <style>
        .header{
            top: 75px;
        }

        .header-controller {
            display: flex;
            gap: 7px;
        }

        .p-content {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: 10px;
            width: 100%;
            box-sizing: border-box;

            .p-card {
                position: relative;
                background: var(--milk);
                transition: 0.25s;
                cursor: pointer;
                border: 1px solid #ccc;
                box-sizing: border-box;

                .card-body {
                    display: flex;
                    flex-direction: column;

                    .pro-brand {
                        font-family: Impact, Haettenschweiler, 'Arial Narrow Bold', sans-serif;
                        text-transform: uppercase;
                        color: var(--coffee-brown);
                        text-overflow: ellipsis;
                    }

                    .pro-name {
                        color: var(--coffee-black);
                        font-weight: 600;
                        display: -webkit-box;
                        -webkit-line-clamp: 3;
                        -webkit-box-orient: vertical;
                        overflow: hidden;
                        text-overflow: ellipsis;
                        word-break: break-word;
                    }

                    .pro-evaluate {
                        display: flex;
                        align-items: center;
                        gap: 5px;

                        .pro-star {
                            display: flex;
                            gap: 3px;
                            color: var(--coffee-brown);
                        }
                    }

                    .btn-control {
                        button {
                            width: 100%;
                            border: 1px solid var(--coffee-black);
                        }

                        button:nth-child(1) {
                            color: var(--milk);
                            background: var(--coffee-black);
                            font-weight: 600;
                            transition: 0.25s ease-in-out;

                            &.action {
                                color: var(--coffee-black);
                                background: var(--milk);
                            }

                            &:hover {
                                color: var(--coffee-black);
                                background: var(--milk);
                                box-shadow: 0 3px 5px var(--coffee-black);
                                transition: 0.25s ease-in-out;
                            }
                        }

                        button:nth-child(2) {
                            transition: 0.25s ease-in-out;

                            &:hover {
                                box-shadow: 0 3px 5px var(--coffee-black);
                                transition: 0.25s ease-in-out;
                            }

                            &.text-bg-danger {
                                border: none;
                            }
                        }
                    }
                }

                .p-top {
                    position: absolute;
                    margin: 5px;
                }

                &:hover {
                    box-shadow: 0 5px 7px var(--coffee-black);
                    transition: 0.4s;
                }
            }
        }
    </style>
</div>
