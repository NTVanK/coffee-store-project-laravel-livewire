@extends('layout.app')

@section('title', 'Giỏ hàng')

@section('content')
    @livewire('app.layout.cartLayout')
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
                <a href="#" class="btn btn-sm btn-outline-dark">Xem tất cả</a>
            </div>
        </div>
        <livewire:layout.showProduct />
    </div>
@endsection
