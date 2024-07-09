<div class="container g-0 mt-3">
    <div class="row g-0">
        <div class="col-xl-8 col-lg-7 col-sm-6 cart-layout">
            <div class="btn btn-sm title">
                Giỏ hàng: ({{ count($carts->list()) ?? 0 }}) sản phẩm
            </div>
            @if (count($carts->list()) > 0)
                <button type="button" class="btn btn-sm btn-danger" wire:click='destroy'>Xóa tất cả</button>
                <table class="table mt-2">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th>Ảnh</th>
                            <th style="width: 300px">Tên</th>
                            <th>Giá</th>
                            <th>SL</th>
                            <th>Tổng</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($carts->list() as $cart)
                            <tr>
                                <th scope="row">{{ $cart['id'] ?? '' }}</th>
                                <td>
                                    <img width="36" height="36" class="img-thumbnail"
                                        src="{{ asset($cart['image']) }}" />
                                </td>
                                <td>
                                    <span>{{ $cart['name'] }}</span>
                                </td>
                                <td class="text-danger-emphasis fw-bold">{{ $cart['price'] }}</td>
                                <td>
                                    <div class="btn-group btn-group-sm quantity">
                                        <button type="button" class="btn"
                                            wire:click='decrease({{ $cart['id'] }})'>-</button>
                                        <input type="number" min="1" id="quantity"
                                            value="{{ $cart['quantity'] }}" readonly />
                                        <button type="button" class="btn"
                                            wire:click='increase({{ $cart['id'] }})'>+</button>
                                    </div>
                                </td>
                                <td class="text-danger-emphasis fw-bold">
                                    {{ $carts->totalPrice($cart['id']) }}
                                </td>
                                <td>
                                    <button type="button" class="btn btn-sm btn-danger"
                                        wire:click='delete({{ $cart['id'] }})'>x</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="w-100 text-center">
                    <img class="object-fit-cover w-50 mt-2" src='{{ asset('assets/img/noproduct.svg') }}'>
                </div>
            @endif
        </div>
        <div class="col-xl-4 col-lg-4 col-sm-6 ps-3 cart-user">
            <div class="card rounded">
                <div class="card-header">
                    Thông tin giỏ hàng
                </div>
                <div class="card-body">
                    <h5 class="card-title">Khách hàng</h5>
                    <div class="card-text form-control">
                        <span><b>Tên:</b> {{Auth::user()->name}}</span>
                        <span><b>Email:</b> {{Auth::user()->email}}</span>
                    </div>
                    <h5 class="card-title mt-4">Thành tiền</h5>
                    <div class="card-text form-control">
                        <span><b>Tổng tiền: (VND)</b> <b class="text-danger">{{$carts->totalItems()}}</b></span>
                        <span><b>Phí ship:</b> <b class="text-danger">1%</b></span>
                        <hr>
                        <span><b>Tổng chi phí: (VND)</b> <b class="text-danger">{{$carts->totalItems() - ($carts->totalItems() * 0.01)}}</b></span>
                    </div>
                </div>
                <div class="card-footer">
                    <a href="{{ route('payment') }}" wire:navigate class="btn w-100">
                        Mua ngay
                    </a>
                </div>
            </div>
        </div>
    </div>

    <style>
        .cart-layout {
            .title {
                background: var(--coffee-black);
                color: var(--milk);
                font-weight: bold;
            }

            table {
                width: 100%;

                thead tr {
                    th {
                        text-align: center;
                        background: var(--coffee-milk);
                        color: var(--coffee-black);
                    }
                }

                tbody tr {
                    td {
                        text-align: center;
                        background: transparent;

                        span {
                            display: block;
                            white-space: nowrap;
                            max-width: 300px;
                            overflow: hidden;
                            text-overflow: ellipsis;
                        }

                        .quantity {
                            box-shadow: 0 3px 3px var(--coffee-brown);

                            input {
                                width: 48px;
                                height: 32px;
                                border: none;
                                text-align: center;
                            }

                            button {
                                background: var(--coffee-black);
                                color: var(--milk);
                                transition: 0.25s;

                                &:hover {
                                    color: var(--coffee-black);
                                    background: var(--milk);
                                    transition: 0.25s;
                                }
                            }
                        }
                    }

                    th {
                        text-align: center;
                    }
                }
            }
        }

        .cart-user {
            border: none;

            .card {
                background: white;
                box-shadow: 0 3px 5px var(--coffee-black);

                .card-header {
                    background: var(--coffee-black);
                    color: var(--milk);
                    font-size: large;
                    font-weight: 600;
                    text-align: center;
                }

                .card-footer a {
                    background: var(--coffee-black);
                    color: var(--milk);
                    font-weight: bold;
                    transition: 0.25s;

                    &:hover {
                        background: var(--milk);
                        color: var(--coffee-black);
                        box-shadow: 0 3px 5px var(--coffee-black);
                        transition: background 0.25s;
                    }
                }

                .card-body{
                    .card-text{
                        display: flex;
                        flex-direction: column;
                        span{
                            padding: 0 30px;
                            display: flex;
                            justify-content: space-between;
                        }
                    }
                }
            }
        }
    </style>
</div>
