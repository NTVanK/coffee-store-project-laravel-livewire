<nav class="navbar navbar-expand-lg sticky-top rounded shadow" style="background: white">
    @php
        if (!function_exists('isRoute')) {
            function isRoute(...$routes)
            {
                return in_array(request()->route()->getName(), $routes);
            }
        }
    @endphp
    <div class="container-fluid d-flex">
        <a class="navbar-brand fw-bold" href="{{ route('admin') }}" wire:navigate>
            <img src="{{ asset('assets') }}/img/LogoC.svg" width="32" height="28"
                class="d-inline-block align-text-top">
            HYDROS
        </a>
        {{--  --}}
        <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar"
            aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        {{--  --}}
        <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
            <div class="offcanvas-header">
                <a class="navbar-brand fw-bold" href="{{ route('admin') }}" wire:navigate>
                    <img src="{{ asset('assets') }}/img/LogoC.svg" width="32" height="28"
                        class="d-inline-block align-text-top">
                    HYDROS
                </a>
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
                <ul class="navbar-nav gap-2 mx-auto">
                    <li class="nav-item">
                        <a href="{{ route('statistics') }}" wire:navigate
                            class="btn btn-sm
                        {{ isRoute('statistics') ? 'btn-dark' : 'btn-outline-dark' }}">
                            Thống kê
                        </a>
                    </li>
                    <li class="nav-item dropdown">
                        <a data-bs-toggle="dropdown"
                            class="btn btn-sm dropdown-toggle dropdown-toggle-split
                        {{ isRoute('category.index', 'brand.index') ? 'btn-dark' : 'btn-outline-dark' }}">
                            Danh mục
                        </a>
                        <ul class="dropdown-menu dropdown-menu-center">
                            <li class="dropdown-item p-0">
                                <a class="btn btn-outline-dark rounded-0 w-100 active" disabled>Danh mục sản phẩm</a>
                            </li>
                            <li class="dropdown-item my-2 p-0">
                                <a class="btn btn-sm btn-outline-dark rounded-0 border-0 w-100"
                                    href="{{ route('category.index') }}" wire:navigate>Danh mục cha</a>
                            </li>
                            <li class="dropdown-item p-0">
                                <a class="btn btn-sm btn-outline-dark rounded-0 border-0 w-100"
                                    href="{{ route('brand.index') }}" wire:navigate>Danh mục thương hiệu</a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a data-bs-toggle="dropdown"
                            class="btn btn-sm dropdown-toggle dropdown-toggle-split
                        {{ isRoute('product.index', 'product.create') ? 'btn-dark' : 'btn-outline-dark' }}">
                            Sản phẩm
                        </a>
                        <ul class="dropdown-menu">
                            <li class="dropdown-item p-0">
                                <a class="btn btn-outline-dark rounded-0 w-100 active" disabled>Quản lí sản phẩm</a>
                            </li>
                            <li class="dropdown-item my-2 p-0">
                                <a class="btn btn-sm btn-outline-dark rounded-0 border-0 w-100"
                                    href="{{ route('product.index') }}" wire:navigate>Sản
                                    phẩm</a>
                            </li>
                            <li class="dropdown-item p-0">
                                <a class="btn btn-sm btn-outline-dark rounded-0 border-0 w-100"
                                    href="{{ route('product.create') }}" wire:navigate>Thêm sản
                                    phẩm</a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.user') }}" wire:navigate
                            class="btn btn-sm
                        {{ request()->route()->getName() == 'admin.user' ? 'btn-dark' : 'btn-outline-dark' }}">
                            Người dùng
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.comment') }}" wire:navigate
                            class="btn btn-sm
                        {{ request()->route()->getName() == 'admin.comment' ? 'btn-dark' : 'btn-outline-dark' }}">
                            Phản hồi
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <div class="dropdown">
            <a class="btn btn-sm" data-bs-toggle="dropdown" data-bs-target="#userInfo" aria-expanded="false"
                id="user">
                <img src="{{ asset(Auth::user()->img) }}" width="32" height="32" class="img-thumbnail"
                    alt="User logo">
            </a>
            <div class="dropdown-menu dropdown-menu-end px-2 border border-dark shadow" id="userInfo"
                style="width: 18rem">
                <img src="{{ asset(Auth::user()->img) }}" class="img-thumbnail img-fluid" alt="User Image">
                <h4 class="text-center my-3">{{ Auth::user()->name }}</h4>
                <a href="{{ route('admin.info') }}" wire:navigate class="btn btn-outline-dark w-100">Thông tin cá
                    nhân</a>
                <a href="{{ route('admin.logout') }}" class="btn btn-outline-dark w-100 mt-2">Đăng xuất</a>
            </div>
        </div>
    </div>
</nav>
