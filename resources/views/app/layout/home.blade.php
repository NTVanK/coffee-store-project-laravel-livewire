@extends('layout.app')

@section('title', 'Trang chủ')

@section('content')
    <div class="container mt-3">
        <div class="row gap-2 g-0">
            <livewire:layout.category />
            <div class="col slider-banner-top shadow">
                <div id="banner-top" class="carousel slide px-5"
                    style="background: url({{ asset('assets/img/backgroundSlide.svg') }})">
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <div class="row p-3 mx-auto">
                                <div class="col-xl-6 col-lg-5 col-sm-6 silde-content my-auto">
                                    <h1>Trung Nguyên Legend</h1>
                                    <h2>Cà phê hoà tan rang xay 3in1 Classic</h2>
                                    <h3 class="text-danger">50.000 (VND)</h3>
                                    <p>Thế hệ cà phê hòa tan rang xay đặc biệt - Hương vị cà phê rang xay tươi mới.</p>
                                    <a href="#" class="btn px-5">Xem ngay</a>
                                </div>
                                <div class="col-xl-6 col-lg-7 col-sm-6 slide-img">
                                    <img
                                        src="https://salt.tikicdn.com/cache/750x750/ts/product/ae/16/e4/964f78b63f511a91c02a40d1dd4c7dd1.jpg.webp">
                                </div>
                            </div>
                        </div>
                        <div class="carousel-item p-3">
                            <div class="row mx-auto">
                                <div class="col-xl-6 col-lg-5 col-sm-6 silde-content my-auto">
                                    <h1>Trung Nguyên Legend</h1>
                                    <h2>Cà phê hoà tan rang xay 3in1 Classic</h2>
                                    <h3 class="text-danger">50.000 (VND)</h3>
                                    <p>Thế hệ cà phê hòa tan rang xay đặc biệt - Hương vị cà phê rang xay tươi mới.</p>
                                    <a href="#" class="btn px-5">Xem ngay</a>
                                </div>
                                <div class="col-xl-6 col-lg-7 col-sm-6 slide-img">
                                    <img src="https://i.pinimg.com/564x/95/d0/ff/95d0ff1a7acbd688de0f6618216472b4.jpg">
                                </div>
                            </div>
                        </div>
                        <div class="carousel-item p-3">
                            <div class="row mx-auto">
                                <div class="col-xl-6 col-lg-5 col-sm-6 silde-content my-auto">
                                    <h1>Trung Nguyên Legend</h1>
                                    <h2>Cà phê hoà tan rang xay 3in1 Classic</h2>
                                    <h3 class="text-danger">50.000 (VND)</h3>
                                    <p>Thế hệ cà phê hòa tan rang xay đặc biệt - Hương vị cà phê rang xay tươi mới.</p>
                                    <a href="#" class="btn px-5">Xem ngay</a>
                                </div>
                                <div class="col-xl-6 col-lg-7 col-sm-6 slide-img">
                                    <img src="https://i.pinimg.com/564x/06/f9/c5/06f9c52a77746eb953abb8340b31c4f8.jpg">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <button class="control-slide-next btn" type="button" data-bs-target="#banner-top" data-bs-slide="next">
                    <i class="fa-solid fa-angle-right"></i>
                </button>
                <button class="control-slide-prev btn" type="button" data-bs-target="#banner-top" data-bs-slide="prev">
                    <i class="fa-solid fa-angle-left"></i>
                </button>
            </div>
        </div>
    </div>

    {{-- Danh mục --}}
    <div class="container mt-3 category">
        <div class="row g-0 category-title">
            <h3 class="col g-0">Danh mục sản phẩm</h3>
            <div class="col text-end g-0">
                <a href="{{ route('allproduct') }}" wire:navigate class="btn btn-sm btn-outline-dark">Xem tất cả</a>
                <button type='button' class="btn btn-sm btn-outline-dark"><i class="fa-solid fa-caret-left"></i></button>
                <button type='button' class="btn btn-sm btn-outline-dark"><i class="fa-solid fa-caret-right"></i></button>
            </div>
        </div>
        <div class="row g-0 category-items">
            @for ($i = 1; $i <= 5; $i++)
                <a href='#' class='btn'>
                    <img width="48" height="48"
                        src="https://i.pinimg.com/564x/34/e7/84/34e7848f7d9fa2e96f57af05d37c0e94.jpg">
                    <span class="fw-bold">
                        Cà phê nguyên chất
                    </span>
                </a>
            @endfor
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

    {{-- Sản phẩm nổi bật --}}
    <div class="container mt-4 product sale">
        <div class="row g-0 product-title">
            <h3 class="col g-0">Sản phẩm nổi bật</h3>
            <div class="col text-end g-0">
                <a href="{{ route('allproduct') }}" wire:navigate class="btn btn-sm btn-outline-dark">Xem tất cả</a>
            </div>
        </div>
        <livewire:layout.showProduct />
    </div>
@endsection
