<div class="d-flex flex-column form-control sidebar-info-user">
    <div class="d-flex align-items-center gap-2">
        <img width="36" height="36"
            src="{{ asset(Auth::user()->img ?? 'https://i.pinimg.com/236x/67/57/0b/67570b92b9ed6dc3169845d987cb4c62.jpg') }}"
            class="img-thumbnail" />
        <b>{{ Auth::user()->name }}</b>
    </div>
    <hr>
    @php
        if (!function_exists('isRoute')) {
            function isRoute(...$routes)
            {
                return in_array(request()->route()->getName(), $routes);
            }
        }
    @endphp
    <ul class="list-group">
        <li class="list-group-item {{ isRoute('user.info') ? 'active' : '' }}"
            onclick="javascript:location.href='{{ route('user.info') }}'">Thông tin cá nhân</li>
        <li class="list-group-item {{ isRoute('user.order') ? 'active' : '' }}"
            onclick="javascript:location.href='{{ route('user.order') }}'">Đơn hàng của tôi</li>
    </ul>
    <hr>
    <a href="{{ route('app.logout') }}" class="btn">Đăng xuất</a>
</div>
