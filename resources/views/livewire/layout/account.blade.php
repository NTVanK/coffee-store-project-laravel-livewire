<div class="dropdown rounded-pill account">
    @if (Auth::check())
        <button type="button" class="btn fw-bold rounded-pill" data-bs-toggle="dropdown" aria-expanded="false"
            data-bs-reference="parent">
            {{ Auth::user()->name ?? 'Ẩn danh' }}
        </button>
        <ul class="dropdown-menu dropdown-menu-end p-1">
            <li class="dropdown-item-fluid" style="width: 15rem">
                <div class="card">
                    <img class="img-fluid card-img-top"
                        src="{{ asset(Auth::user()->img ?? 'https://i.pinimg.com/236x/67/57/0b/67570b92b9ed6dc3169845d987cb4c62.jpg') }}" alt="user-img" />
                    <div class="card-footer text-center fw-bold p-2">{{ Auth::user()->name ?? 'Ẩn danh' }}</div>
                </div>
            </li>
            <li class="dropdown-item mt-1 btn-user" onclick="javascript:location.href='{{ route('user.info') }}'">
                Thông tin cá nhân
            </li>
            <li class="dropdown-item mt-1 btn-user" onclick="javascript:location.href='{{ route('user.order') }}'">
                Đơn hàng của tôi
            </li>
            <li class="dropdown-item mt-1 btn-user" onclick="javascript:location.href='{{ route('app.logout') }}'">
                Đăng xuất
            </li>
        </ul>
    @else
        <a href="{{ route('app.register', ['route' => 'register']) }}" wire:navigate
            class="btn rounded-pill register">Đăng kí</a>
        <a href="{{ route('app.login') }}" wire:navigate class="btn rounded-pill login">Đăng nhập</a>
    @endif
</div>
