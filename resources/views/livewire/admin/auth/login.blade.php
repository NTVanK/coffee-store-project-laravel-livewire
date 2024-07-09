<div class="container py-5 h-100 shadow" style="background: url({{ asset('assets/img/background.svg') }})">
    <div class="row d-flex h-100">
        <div class="col-md-8 col-lg-7 col-xl-6">
            <img class="img-fluid mx-auto d-block" src="{{ asset('assets/img/logoA.svg') }}" style="width: 80%" />
        </div>
        <div class="col-md-7 col-lg-5 col-xl-4 offset-xl-1">
            <form wire:submit.prevent='authencate' class="form-control py-5 px-4 shadow">

                <div class="d-flex">
                    <div class="d-flex align-items-center gap-2">
                        <img src="{{ asset('assets') }}/img/LogoC.svg" width="38" height="38"
                            class="d-inline-block align-text-top">
                        <span class="fs-5 fw-bold">HYDROS</span>
                    </div>
                    <a href="{{ route('home') }}" class='btn btn-outline-dark ms-auto'>Website</a>
                </div>

                <h3 class="fw-bold text-center my-3 py-2 rounded text-primary border border-primary rounded">
                    Đăng nhập Admin
                </h3>
                <!-- Nhập tên đăng nhập -->
                <div class="form-outline mt-3">
                    <label class="form-label fs-6 fw-bold" for="email">Email đăng nhập</label>
                    <input type="text" class="form-control" id="email" autocomplete="email"
                        wire:model.live.debounce:150ms='email' required>
                    @error('email')
                        <small class="fw-bold text-danger mt-1"
                            wire:transition.scale.opacity.top>{{ $message ?? '' }}</small>
                    @enderror
                </div>

                <!-- Nhập mật khẩu -->
                <div class="form-outline mt-3">
                    <label class="form-label fs-6 fw-bold" for="username">Mật khẩu</label>
                    <div class="input-group">
                        <input type="{{ $showPassword['type'] }}" class="form-control" id="password"
                            autocomplete="password" wire:model.live.debounce:150ms='password' required>
                        <button type="button" class="btn btn-dark" wire:click.live='show'>
                            <i class="fa-solid {{ $showPassword['show'] }}"></i>
                        </button>
                    </div>
                    <small class="mt-1">Độ dài mật khẩu( 8-20 ký tự )</small>
                    @error('password')
                        <br>
                        <small class="fw-bold text-danger mt-1"
                            wire:transition.scale.opacity.top>{{ $message ?? '' }}</small>
                    @enderror
                </div>
                <hr>
                <button type="submit" class="btn btn-primary fw-bold w-100">Đăng nhập</button>
            </form>
        </div>
    </div>
</div>
