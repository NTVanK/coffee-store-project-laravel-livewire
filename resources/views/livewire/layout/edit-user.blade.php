<div class="editUser rounded p-2">
    <div class="edit-img">
        <input type="file" class="form-control" id="img-user" wire:model.live='photo'
            @if (!$action) disabled @endif>

        @if (is_object($photo) && method_exists($photo, 'temporaryUrl'))
            <img class="img-thumbnail" src="{{ $photo->temporaryUrl() }}" class="d-block mx-auto w-75">
        @else
            <img class="img-thumbnail"
                src="{{ asset($photo ?? 'https://i.pinimg.com/564x/65/d6/c4/65d6c4b0cc9e85a631cf2905a881b7f0.jpg') }}"
                class="d-block mx-auto w-75">
        @endif

        @error('photo')
            <span class="error">{{ $message }}</span>
        @enderror
    </div>
    <div class="vr"></div>
    <div class="edit-user">
        <div class="form-control w-100 d-flex justify-content-between align-items-center title">
            <b class="w-100">Thông tin người dùng:</b>
            <button class="btn btn-sm {{ $action ? 'btn-danger' : 'btn-primary' }}" style="width: 30%"
                wire:click='show'>
                {{ $action ? 'Đóng' : 'Thêm / Sửa' }}
            </button>
        </div>
        {{--  --}}
        @if ($alert)
            <div class="form-control d-flex align-items-center text-danger bg-danger-subtle mt-2"
                wire:transition.scale.opacity.top>
                <div class="fw-bold">
                    Vui lòng nhập thông tin trước khi thanh toán!
                </div>
            </div>
        @endif
        {{--  --}}
        <div class="mt-3">
            <label for="email" class="form-label fw-bold">Email</label>
            <input type="email" class="form-control" id="email" value="{{ Auth::user()->email }}" readonly>
        </div>

        <div class="mt-3">
            <label for="name" class="form-label fw-bold">Tên người dùng</label>
            <input type="email" class="form-control" id="name" wire:model.live='name'
                @if (!$action) readonly @endif>
            @error('name')
                <div class="invalid-feedback fw-bold" wire:transition.scale.opacity.top>
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="mt-3">
            <label for="phone" class="form-label fw-bold">Số điện thoại</label>
            <input type="text" class="form-control" id="phone" wire:model.live='phone'
                @if (!$action) readonly @endif>
            @error('phone')
                <div class="invalid-feedback fw-bold" wire:transition.scale.opacity.top>
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="mt-3">
            <label for="home_address" class="form-label fw-bold">Địa chỉ</label>
            <input type="text" class="form-control" id="home_address" wire:model.live='home_address'
                @if (!$action) readonly @endif>
        </div>

        @if ($action)
            <button type="button" class="btn btn-success mt-4 w-50" wire:click='editUser'
                wire:transition.scale.opacity.top>
                Lưu thay đổi
            </button>
        @endif
    </div>
    <style>
        .editUser {
            display: flex;
            gap: 10px;
            background: white;
            border: 1px solid var(--coffee-black);
            box-shadow: 0 3px 3px var(--coffee-black);

            .edit-img {
                width: 35%;
                display: flex;
                flex-direction: column;
                gap: 6px;

                input {
                    border: 1px solid var(--coffee-black);
                    background: var(--coffee-black);
                    color: var(--milk);
                }
            }

            .edit-user {
                width: 65%;
                display: flex;
                flex-direction: column;
                align-items: center;

                .title {
                    background: var(--coffee-black);
                    color: var(--milk);
                }

                div {
                    width: 100%;

                    input {
                        box-shadow: 0 3px 3px var(--coffee-black);
                    }

                    input:focus {
                        border: 1px solid var(--coffee-black);
                    }
                }
            }
        }
    </style>
</div>
