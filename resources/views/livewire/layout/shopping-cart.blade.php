<div class="dropdown cart">
    <button type="button" class="btn rounded-pill position-relative btn-carts" wire:click='RedirectCarts'>
        <i class="fa-solid fa-cart-shopping fa-lg"></i>
        @auth
            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                {{ count($carts->list()) }}
            </span>
        @endauth

    </button>
    <div class="card shadow">
        @if (Auth::check())
            @if (count($carts->list()) > 0)
                <h5 class="card-header fw-blod">Đã thêm ({{ count($carts->list()) }}) sản phẩm</h5>
                <div class="card-body bg-body-secondary">
                    @foreach ($carts->list() as $cart)
                        <div class="cart-label">
                            <img class="rounded" src="{{ asset($cart['image']) }}" />
                            <div class="pro-info">
                                <h6 class="fw-bold">{{ $cart['name'] }}</h6>
                                <h7 class="text-danger bg-danger-subtle rounded fw-bold px-2">{{ $cart['price'] }}
                                    (VND)
                                </h7>
                            </div>
                        </div>
                        <hr>
                    @endforeach
                </div>
                <a href="{{ route('cart') }}" wire:navigate class="btn card-footer">Xem giỏ hàng</a>
            @else
                <div class="card-body">
                    <img class="img-thumbnail object-fit-cover w-100" src='{{ asset('assets/img/noproduct.svg') }}'>
                </div>
            @endif
        @else
            <div class="card-body bg-danger-subtle text-danger fw-bold">
                Đăng nhập để sử dụng tính năng này!
            </div>
        @endif
    </div>
</div>
