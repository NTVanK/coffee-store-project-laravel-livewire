<div class="footer-area py-3 mt-5">
    <div class="container">
        <div class="row g-0">
            <div class="col-md-3 px-3">
                <a href="{{ route('home') }}">
                    <img src="{{ asset('assets/img/logoC.svg') }}" width="38" height="38" alt="Logo">
                    <span class='fw-bold fs-3'>HYDROS</span>
                </a>
                <hr>
                <p>
                    Chào mừng đến với Hydros - nơi bạn có thể khám phá và trải nghiệm hương vị tinh tế của cà phê và trà từ khắp nơi trên thế giới.
                </p>
            </div>
            <div class="col-md-3 px-3">
                <h3>Danh mục</h3>
                <div class="mb-2"><a href="{{ url('/') }}" class="text-white">Trang chủ</a></div>
                <div class="mb-2"><a href="{{ url('about-us') }}" class="text-white">Thông tin</a></div>
                <div class="mb-2"><a href="{{ url('contact-us') }}" class="text-white">Liên hệ</a></div>
                <div class="mb-2"><a href="{{ url('blogs') }}" class="text-white">Bài viết</a></div>
                <div class="mb-2"><a href="#" class="text-white">Cửa hàng</a></div>
            </div>
            <div class="col-md-3 px-3">
                <h3>Hydros</h3>
                <div class="mb-2"><a href="{{ url('/') }}" class="text-white">Sản phẩm</a></div>
                <div class="mb-2"><a href="{{ url('/') }}" class="text-white">Sản phẩm nổi bật</a></div>
                <div class="mb-2"><a href="{{ url('/') }}" class="text-white">Sản phẩm mới</a>
                </div>
                <div class="mb-2"><a href="{{ url('/') }}" class="text-white">Sản phẩm bán chạy</a></div>
                <div class="mb-2"><a href="{{ url('/') }}" class="text-white">Giỏ hàng</a></div>
            </div>
            <div class="col-md-3 px-3">
                <h3>Liên hệ</h3>
                <div class="mb-2">
                    <a href="" class="text-white">
                        <i class="fa fa-map-marker"></i> {{ $appSetting->phone1 ?? 'address' }}
                    </a>
                </div>
                <div class="mb-2">
                    <a href="" class="text-white">
                        <i class="fa fa-phone"></i> {{ $appSetting->phone1 ?? 'phone' }}
                    </a>
                </div>
                <div class="mb-2">
                    <a href="" class="text-white">
                        <i class="fa fa-envelope"></i> {{ $appSetting->email1 ?? 'email' }}
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="copyright-area">
    <div class="container">
        <div class="row g-0 px-3">
            <div class="col-md-8">
                <p class=""> &copy; 2023 - EShop. All rights reserved.</p>
            </div>
            <div class="col-md-4 text-end">
                <div class="social-media">
                    Get Connected:
                    <a href="{{ $appSetting->facebook ?? '#' }}" target="_blank"><i class="fa fa-facebook"></i></a>
                    <a href="{{ $appSetting->twitter ?? '#' }}" target="_blank"><i class="fa fa-twitter"></i></a>
                    <a href="{{ $appSetting->instagram ?? '#' }}" target="_blank"><i class="fa fa-instagram"></i></a>
                    <a href="{{ $appSetting->youtube ?? '#' }}" target="_blank"><i class="fa fa-youtube"></i></a>
                </div>
            </div>
        </div>
    </div>
</div>
