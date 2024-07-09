<div class="toast rounded-0 border-0 p-1 px-3 fade show line-top" role="alert" aria-live="assertive" aria-atomic="true">
    <div></div>
    <span class="fw-bold">
        <i class="fa-solid fa-bolt fa-beat-fade"></i>
        Cà phê sửa Trung Nguyên Legend hot sale
        <i class="fa-solid fa-bolt fa-beat-fade"></i>
    </span>
    <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
</div>

<nav class="navbar navbar-expand-lg sticky-top z-3 shadow">
    @php
        if (!function_exists('isRoute')) {
            function isRoute(...$routes)
            {
                return in_array(request()->route()->getName(), $routes);
            }
        }
    @endphp
    <div class="container">
        <a href="{{ route('home') }}" class="col navbar-brand d-flex align-items-center gap-2">
            <img src="{{ asset('assets/img/logoC.svg') }}" width="38" height="38" alt="Logo">
            <span class='fw-bold fs-3'>HYDROS</span>
        </a>
        {{--  --}}
        <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar"
            aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        {{--  --}}
        <div class="offcanvas offcanvas-end rounded-2 m-2" tabindex="-1" id="offcanvasNavbar"
            aria-labelledby="offcanvasNavbarLabel">
            <div class="offcanvas-header">
                <a href="{{ route('home') }}" class="navbar-brand d-flex align-items-center gap-2">
                    <img src="{{ asset('assets/img/logoC.svg') }}" width="38" height="38" alt="Logo">
                    <span class='fw-bold fs-3'>HYDROS</span>
                </a>
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
                <ul class="navbar-nav flex-grow-1 align-items-lg-center gap-2">
                    <li class="nav-item">
                        <a href="{{ route('allproduct') }}" class="btn btn-outline-dark {{isRoute('allproduct') ? 'active' : ''}}" wire:navigate>
                            Tất cả sản phẩm
                        </a>
                    </li>
                    <li class="nav-item col-xl-6">
                        <livewire:app.layout.searchProduct />
                    </li>
                    <li class="nav-item d-flex gap-4 ms-xl-auto">
                        <livewire:layout.shoppingCart />
                        <livewire:layout.account />
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>

<div class="btn" id='BackToTop'>
    <i class="fa-solid fa-jet-fighter-up"></i>
</div>
