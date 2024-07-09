@extends('layout.app')

@section('title', 'Hóa đơn sản phẩm')

@section('content')
    <div class="container w-50 mt-3 px-3 py-2 bill">
        <div class="title">
            <a href="{{ route('home') }}" class="col navbar-brand d-flex align-items-center gap-2">
                <img src="{{ asset('assets/img/logoC.svg') }}" width="38" height="38" alt="Logo">
                <span class='fw-bold fs-3'>HYDROS</span>
            </a>
            <span class='fw-bold fs-3'>HÓA ĐƠN</span>
        </div>
        <hr>
        <div class="row g-0">
            <h5 class="form-control">Thông tin khách hàng</h5>
            <div class="px-3">
                <b>Email: </b>
                <span>{{ Auth::user()->email }}</span>
            </div>
            <div class="px-3">
                <b>Tên: </b>
                <span>{{ Auth::user()->name }}</span>
            </div>
            <div class="px-3">
                <b>Số điện thoại: </b>
                <span>{{ $infor->phone }}</span>
            </div>
            <div class="px-3">
                <b>Địa chỉ: </b>
                <span>{{ $infor->home_address }}</span>
            </div>
        </div>
        <hr>
        <div class="row g-0">
            <h5 class="form-control">Sản phẩm đặt hàng</h5>
            <table class="table rounded">
                <thead>
                    <tr>
                        <th>Tên sản phẩm</th>
                        <th>Giá sản phẩm</th>
                        <th>Số lượng</th>
                        <th>Thành tiền</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($orderItems as $item)
                        <tr>
                            <td class="name_pro">
                                <span>{{ $item->product->name }}</span>
                            </td>
                            <td class="text-danger-emphasis fw-bold">{{ $item->unit_amount }}</td>
                            <td class="text-danger fw-bold">{{ $item->quantity }}</td>
                            <td class="text-danger-emphasis fw-bold">{{ $item->total_amount }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="4" class="text-end">
                            <span class="text-danger">Tổng giá (VND):</span>
                            <span class="text-danger-emphasis ms-3">{{ $order->grand_total }}</span>
                        </th>
                    </tr>
                </tfoot>
            </table>
        </div>
        <hr>
        <div class="row g-0">
            <h5 class="form-control">Cổng thanh toán</h5>
            <table class="table rounded">
                <thead>
                    <tr>
                        <th>Phương thức tt</th>
                        <th>Trang thái tt</th>
                        <th>Mệnh giá</th>
                        <th>Chi phí vận chuyển</th>
                        <th>Hình thức vận chuyển</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{ $order->payment_method == 'direct' ? 'Trực tiếp' : 'VnPay' }}</td>
                        <td>{{ $order->payment_status == 'waite' ? 'Chưa tt' : 'Đã tt' }}</td>
                        <td class="text-danger fw-bold">{{ $order->currency }}</td>
                        <td class="text-danger-emphasis fw-bold">{{ $order->shipping_amout }}</td>
                        <td class="">{{ $order->shipping_method == 'fast' ? 'Chuyển phát nhanh' : '' }}</td>
                    </tr>
                </tbody>
            </table>

            <b class="form-label text-danger fw-bold">Ghi chú</b>
            <div class="form-control">
                {{ $order->notes ?? 'Không có ghi chú nào!' }}
            </div>
        </div>
        <hr>
        <h3 class="text-center w-100 fw-bold text-danger-emphasis">
            CẢM ƠN QUÝ KHÁCH ĐÃ ĐẶT HÀNG
        </h3>
    </div>
    
    <div class="text-center mt-5"> 
        <a href="{{ route('home') }}" class="btn btn-lg btn-outline-danger fw-bold">
            Quay lại trang chủ
        </a>
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
        .bill {
            background: var(--milk);
            border: 1px solid var(--coffee-brown);
            border-radius: 1rem;
            box-shadow: 0 3px 3px var(--coffee-black);

            .title {
                display: flex;
                align-items: center;
                justify-content: space-between;
            }

            .row {
                h5 {
                    width: max-content;
                    background: var(--coffee-black);
                    color: var(--milk);
                }

                table {
                    box-shadow: 0 3px 3px var(--coffee-black);
                    border: 1px solid var(--coffee-brown);
                    overflow: hidden;

                    thead tr th {
                        text-align: end;
                        width: max-content;
                        min-width: max-content;
                    }

                    tbody tr td {
                        text-align: end;

                        span {
                            display: block;
                            white-space: nowrap;
                            width: 450px;
                            max-width: 100%;
                            overflow: hidden;
                            text-overflow: ellipsis;
                        }
                    }
                }
            }
        }
    </style>
@endsection
