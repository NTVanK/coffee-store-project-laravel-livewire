<form wire:submit.prevent='authencate' class="form-control py-4 px-3 shadow">
    <h3 class="fw-bold text-center py-2 rounded text-primary border border-primary rounded">
        Đăng nhập
    </h3>
    <!-- Nhập tên đăng nhập -->
    <div class="form-outline mt-3">
        <label class="form-label fs-6 fw-bold" for="email">Tên đăng nhập</label>
        <input type="text" class="form-control" id="email" name="email" autocomplete="email"
            wire:model='email' required>
    </div>

    <!-- Nhập mật khẩu -->
    <div class="form-outline mt-2">
        <label class="form-label fs-6 fw-bold" for="password">Mật khẩu</label>
        <div class="input-group">
            <input type="{{ $showPassword['type'] }}" class="form-control" id="password" name="password"
                autocomplete="password" wire:model.live.debounce:150ms='password' required>
            <button type="button" class="btn btn-dark" wire:click.live='show'>
                <i class="fa-solid {{ $showPassword['show'] }}"></i>
            </button>
        </div>

        @error('password')
            <small class="fw-bold text-danger mt-1" wire:transition.scale.opacity.top>{{ $message ?? '' }}</small>
        @enderror
    </div>
    <div class="d-flex justify-content-between mt-1">
        <div class="form-check">
            <input class="form-check-input" type="checkbox" value="1" id="remember">
            <label class="form-check-label text-primary" for="remember">
                Ghi nhớ tài khoản
            </label>
        </div>
        <a href="{{ route('app.register', ['route' => 'forgotPassword']) }}" wire:navigate class="text-decoration-none">Quên mật khẩu</a>
    </div>
    <button type="submit" class="btn btn-primary fw-bold w-100 mt-4">Đăng nhập</button>

    <small class="d-flex justify-content-center align-items-center gap-3 my-2">
        <hr style="width: 35%">
        Hoặc
        <hr style="width: 35%">
    </small>

    <button class="btn btn-danger fw-bold w-100">
        <i class="fa-brands fa-square-google-plus"></i>
        Google
    </button>

    <div class="text-center mt-3">
        Bạn đã có tài khoản chưa?
        <a href="{{ route('app.register', ['route' => 'register']) }}" wire:navigate class="text-decoration-none">Đăng kí ngay</a>
    </div>
</form>
