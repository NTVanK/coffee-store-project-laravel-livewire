<form wire:submit.prevent='create' class="form-control py-4 px-3 shadow" id="verificationForm">
    <h3 class="fw-bold text-center py-2 rounded text-primary border border-primary rounded">
        Đăng kí
    </h3>

    <!-- Nhập Email đã xác thực -->
    <div class="form-outline mt-3">
        <label class="form-label fs-6 fw-bold" for="email">Email đăng kí</label>
        <input type="email" class="form-control" id="email" autocomplete="email" wire:model='email' readonly>
    </div>

    <!-- Nhập tên tài khoản-->
    <div class="form-outline mt-3">
        <label class="form-label fs-6 fw-bold" for="email">Nhập tên người dùng</label>
        <input type="text" class="form-control" id="username" autocomplete="username" wire:model='username'
            required>
    </div>

    <!-- Nhập mật khẩu tài khoản-->
    <div class="form-outline mt-2">
        <label class="form-label fs-6 fw-bold" for="username">Nhập mật khẩu</label>
        <div class="input-group">
            <input type="{{ $showPassword['type'] }}" class="form-control" id="password" autocomplete="password"
                wire:model.live.debounce:150ms='password' required>
            <button type="button" class="btn btn-dark" wire:click.live='show("showPassword")'>
                <i class="fa-solid {{ $showPassword['show'] }}"></i>
            </button>
        </div>

        @error('password')
            <small class="fw-bold text-danger mt-1" wire:transition.scale.opacity.top>{{ $message ?? '' }}</small>
        @enderror
    </div>

    <!-- Nhập lại mật khẩu tài khoản-->
    <div class="form-outline mt-2">
        <label class="form-label fs-6 fw-bold" for="username">Nhập lại mật khẩu</label>
        <div class="input-group">
            <input type="{{ $showRePassword['type'] }}" class="form-control" id="rePassword" autocomplete="rePassword"
                wire:model.live.debounce:150ms='rePassword' required>
            <button type="button" class="btn btn-dark" wire:click.live='show("showRePassword")'>
                <i class="fa-solid {{ $showRePassword['show'] }}"></i>
            </button>
        </div>

        @error('rePassword')
            <small class="fw-bold text-danger mt-1" wire:transition.scale.opacity.top>{{ $message ?? '' }}</small>
        @enderror
    </div>

    <button type="submit" class="btn btn-primary fw-bold w-100 mt-3">
        Đăng kí
    </button>

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
        <a href="{{ route('app.login') }}" wire:navigate class="text-decoration-none">Đăng nhập ngay</a>
    </div>
</form>
