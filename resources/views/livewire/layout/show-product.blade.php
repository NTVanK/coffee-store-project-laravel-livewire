<div class="row g-0 form-control">
    <div class="p-control">
        <button type="button" class="btn btn-sm " wire:click='changePage("prev")' @if($products->onFirstPage()) disabled @endif>
            <i class="fa-solid fa-caret-left"></i>
            Trang sau
        </button>

        <button type="button" class="btn btn-sm" wire:click='changePage("next")' @if(!$products->hasMorePages()) disabled @endif>
            Trang tiếp
            <i class="fa-solid fa-caret-right"></i>
        </button>
    </div>


    <div class="p-content mt-1">
        @forelse ($products as $product)
            <div class="card p-card">
                <button class="btn bg-danger-subtle text-danger p-top active">
                    New
                </button>
                <img class="card-img-top" src="{{ asset($product->image[0]) }}" alt="..." onclick="javascript:location.href='{{ route('detail', ['id' => $product->id]) }}'"/>
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
                    <div class="pro-evaluate mt-auto">
                        <div class="pro-star">
                            @for ($j = 1; $j <= 5; $j++)
                                <i class="fa-regular fa-star fa-sm"></i>
                            @endfor
                        </div>
                        <div class="vr"></div>
                        <div class="">Đã bán: 1.8K</div>
                    </div>
                    <div class="d-flex mt-2 btn-control">
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

    <style>
        .p-control {
            display: flex;
            justify-content: end;
            gap: 5px;

            button {
                background: var(--coffee-black);
                color: var(--milk);
                font-weight: bold;
                transition: 0.25s;

                &:hover {
                    transition: 0.25s;
                }
            }
        }

        .p-content {
            width: 100%;
            display: flex;
            gap: 10px;

            .p-card {
                width: 20%;
                position: relative;
                background: var(--milk);
                transition: 0.25s;
                cursor: pointer;

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
                        text-align: justify;
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
