<div class="container g-0 detail-product">
    <div class="row justify-content-evenly g-0">
        <div class="col-xl-3 p-1 sticky-xl-top z-2">
            @isset($product->image)
                <div id="carouselExample" class="carousel slide form-control shadow" data-bs-ride="carousel"
                    style="height: max-content">
                    <div class="carousel-inner">

                        @foreach ($product->image as $key => $img)
                            <div class="carousel-item {{ $key == 0 ? 'active' : null }}">
                                <img src="{{ asset($img) }}" class="d-block mx-auto w-75 img-thumbnail">
                            </div>
                        @endforeach

                    </div>
                    @if ($product->image[1] != null)
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
        </div>
        <div class="col-xl-5 p-2">
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
            <hr>
            <div class="form-control bg-primary-subtle text-primary mt-2">
                <b>{{ $product->name ?? '' }}</b>
            </div>
            <div class="d-flex gap-2 p-1 text-warning mt-2">
                <div class="pro-star">
                    @for ($j = 1; $j <= 5; $j++)
                        <i class="fa-solid fa-star fa-sm"></i>
                    @endfor
                </div>
                <div class="vr"></div>
                <div class="text-warning-emphasis">Đã bán: 1.8K</div>
            </div>
            <div class="form-control bg-danger-subtle text-danger mt-2" style="width: max-content">
                <b>{{ $product->price ?? '' }} (VND)</b>
            </div>
            <hr>

            <h5>Nguồn sản phẩm</h5>
            <div class="form-control">
                <b>Loại sản phẩm: </b> {{ $product->category->name ?? '' }}
                <br>
                <b>Thương hiệu:</b> {{ $product->brand->name ?? '' }}</b>
            </div>

            <h5 class="mt-4">Thông tin sản phẩm</h5>
            <div class="form-control text-justify description-product">
                {!! $product->description ?? '' !!}
            </div>
        </div>
        <div class="col-xl-3 p-3 sticky-xl-top z-2">
            <h4>Thông tin mua hàng</h4>
            <hr>
            <h6>Giá sản phẩm</h6>
            <div class="form-control">
                <b>Giá gốc: </b><b class="text-danger-emphasis">{{ $product->price }} (VND)</b>
                <br>
                <b>Tổng giá: </b><b class="text-success-emphasis">{{ $product->price * $quantity }} (VND)</b>
            </div>
            <h6 class="mt-3">Số lượng</h6>
            <div class="btn-group w-100">
                <button class="btn btn-dark w-50" wire:click='minus'>
                    <i class="fa-solid fa-minus"></i>
                </button>
                <input type="text" class="form-control bg-info-subtle fw-bold text-center"
                    value="{{ $quantity }}" disabled>
                <button class="btn btn-dark w-50" wire:click='plus'>
                    <i class="fa-solid fa-plus"></i>
                </button>
            </div>
            <hr>
            @if (isset($carts[$product->id]) && $carts[$product->id]['id'] == $product->id)
                <button type="button" class="btn btn-outline-primary w-100" wire:click='deleteCart({{ $product->id }})'>
                    <i class="fa-solid fa-cart-arrow-down me-1"></i>
                    Đã thêm
                </button>
            @else
                <button type="button" class="btn btn-primary w-100" wire:click='addCart({{ $product->id }})'>
                    <i class="fa-solid fa-cart-arrow-down me-1"></i>
                    Thêm giỏ hàng
                </button>
            @endif
        </div>
    </div>
</div>
