<form wire:submit.prevent='{{ $event }}' class="form-control py-4 px-3 shadow" id="verificationForm">
    <h3 class="fw-bold text-center py-2 rounded text-primary border border-primary rounded">
        {{$route == 'app.register.create' ? 'Đăng kí' : 'Quên mật khẩu' }}
    </h3>

    <!-- Nhập Email -->
    <div class="form-outline mt-3">
        <label class="form-label fs-6 fw-bold" for="email">Nhập Email {{$route == 'app.register.create' ? 'đăng kí' : 'của bạn' }}</label>
        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email"
            autocomplete="email" wire:model.live='email' {{ $event == 'verifyEmail' ? 'readonly' : 'required' }}>

        @error('email')
            <small class="fw-bold text-danger mt-1" wire:transition.scale.opacity.top>{{ $message ?? '' }}</small>
        @enderror
    </div>

    @if ($event == 'verifyEmail')
        <div class="form-outline mt-3" wire:transition.scale.origin.top>
            <label class="form-label fs-6 fw-bold" for="email">Nhập mã xác nhận</label>
            <span>{{ $otp }}</span>
            <div class="input-group">
                <input type="number" class="form-control" id="verifyOTP" wire:model.live='verifyOTP'>
                <span class="btn btn-dark" wire:click="replaySendOTP">Gửi lại mã xác nhận</span>
            </div>

            @error('otp')
                <small class="fw-bold text-danger mt-1" wire:transition.scale.opacity.top>{{ $message ?? '' }}</small>
            @enderror
        </div>
    @endif

    <button type="submit" class="btn btn-primary fw-bold w-100 mt-3">
        {{ $event == 'verifyEmail' ? 'Xác nhận' : 'Gửi mã xác nhận' }}
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

