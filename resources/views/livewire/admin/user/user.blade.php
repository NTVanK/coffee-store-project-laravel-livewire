<div class="container user-all" id="showComponent">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mt-3">
        <h1 class="h3 mb-0 fw-bold text-gray-800">Người dùng</h1>
        <input type="search" class="form-control" style="width: 40%" id='search' wire:model.live='search'
            placeholder="Tìm kiếm..." />
    </div>
    <table class="table table-hover table-condensed mt-2 rounded overflow-hidden">
        <thead class="table-dark">
            <th>Ảnh</th>
            <th>Tên</th>
            <th>Email</th>
            <th>Số điện thoại</th>
            <th>Địa chỉ</th>
            <th>Chức năng</th>
        </thead>
        <tbody>
            @foreach ($infors as $infor)
                <tr>
                    <td>
                        <img src="{{ asset($infor->user->img ?? 'assets\img\background.svg') }}"
                            class="img-thumbnail img-profile" alt="logo">
                    </td>
                    <td>
                        {{ $infor->user->name }}
                    </td>
                    <td>
                        {{ $infor->user->email }}
                    </td>
                    <td>
                        {{ $infor->phone }}
                    </td>
                    <td>
                        {{ $infor->address }}
                    </td>
                    <td>
                        <button type="button" class="btn btn-sm btn-success"
                            wire:click='show({{ $infor->id }})'>Sửa</button>
                    </td>
                </tr>
            @endforeach
            @if ($infors->count() == 0)
                <tr>
                    <td colspan="6" class="text-bg-danger">
                        Không có người dùng nào!
                    </td>
                </tr>
            @endif
        </tbody>
    </table>

    @if ($name)
        <div class="editUser rounded p-2" id='showComponent'>
            <div class="edit-img">
                <input type="file" class="form-control border border-dark" id="img-user" wire:model.live='photo'
                    @if (!$action) disabled @endif>

                @if (is_object($photo) && method_exists($photo, 'temporaryUrl'))
                    <img class="img-thumbnail img-avatar" src="{{ $photo->temporaryUrl() }}" class="d-block mx-auto w-75">
                @else
                    <img class="img-thumbnail img-avatar"
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
                    <button class="btn btn-sm {{ $action ? 'btn-outline-danger' : 'btn-outline-primary' }}" style="width: 30%"
                        wire:click='showEdit'>
                        {{ $action ? 'Đóng' : 'Thêm / Sửa' }}
                    </button>
                    <button class="btn btn-sm btn-danger ms-2"
                        wire:click='resetData'>
                        <i class="fa-solid fa-close"></i>
                    </button>
                </div>
                {{--  --}}
                <div class="mt-3">
                    <label for="email" class="form-label fw-bold">Email</label>
                    <input type="email" class="form-control" id="email" value="{{ $email }}"
                        readonly>
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
        </div>
    @endif

    <style>
        .img-profile {
            width: 32px;
            height: 32px;
            object-fit: cover;
        }

        .img-avatar{
            width: 100%;
            aspect-ratio: 1/1;
            object-fit: cover;
        }

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
