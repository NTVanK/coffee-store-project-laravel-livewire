@extends('layout.app')

@section('title', 'Kiểm tra thông tin thanh toán')

@section('content')
    <div class="container g-0 mt-3">
        <div class="row g-0">
            <div class="col-xl-8 col-lg-7 col-sm-6">
                @livewire('layout.editUser')
                <div class="cart mt-3 w-100">
                    <div class="title w-100">
                        <div class="btn btn-sm">
                            Số lượng: ({{ count($carts->list()) ?? 0 }}) sản phẩm
                        </div>
                        <a href="{{ route('cart') }}" class="btn btn-sm btn-danger" wire:navigate>Sửa</a>
                    </div>
                    <table class="table rounded">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th>Ảnh</th>
                                <th style="width: 300px">Tên</th>
                                <th>Giá</th>
                                <th>SL</th>
                                <th>Tổng</th>
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
                                    <td><span>{{ $cart['name'] }}</span></td>
                                    <td class="text-danger fw-bold">{{ $cart['price'] }}</td>
                                    <td class="text-danger-emphasis fw-bold">{{ $cart['quantity'] }}</td>
                                    <td class="text-danger fw-bold">
                                        {{ $carts->totalPrice($cart['id']) }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="6" class="text-end px-4">
                                    Tổng tiền:
                                    {{$carts->totalItems()}}
                                    (VND)
                                </th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
            <div class="col-xl-4 col-lg-4 col-sm-6 ps-3">
                @livewire('layout.editPayment')
            </div>
        </div>
    </div>

    <div id="banner-middle" class="container g-0 mt-5 carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="{{ asset('assets/img/banner-1.svg') }}" class="d-block w-100" alt="...">
            </div>
            <div class="carousel-item">
                <img src="{{ asset('assets/img/banner-2.svg') }}" class="d-block w-100" alt="...">
            </div>
            <div class="carousel-item">
                <img src="{{ asset('assets/img/banner-3.svg') }}" class="d-block w-100" alt="...">
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#banner-middle" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#banner-middle" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
@endsection

@section('css')
    <style>
        .cart {
            display: flex;
            flex-direction: column;
            align-items: start;
            gap: 7px;

            .title {
                display: flex;
                justify-content: space-between;

                div {
                    background: var(--coffee-black);
                    color: var(--milk);
                    font-weight: bold;
                    box-shadow: 0 3px 3px var(--coffee-black);
                }
            }

            table {
                border: 1px solid var(--coffee-black);
                overflow: hidden;
                box-shadow: 0 3px 3px var(--coffee-black);

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
                    }

                    th {
                        text-align: center;
                    }
                }

                tfoot tr th{
                    background: var(--coffee-milk);
                    color: var(--coffee-black);
                }
            }
        }
    </style>
@endsection
