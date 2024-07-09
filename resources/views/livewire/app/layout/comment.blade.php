<div class="container mt-5">
    <hr>
    <h3 class="mt-3">Đánh giá sản phẩm</h3>
    <div class="d-flex gap-2">
        <div class="form-control px-4 py-3 comment" style="width: 80%">
            <div class="d-flex gap-2">
                <button type="button" class="btn bg-danger-subtle text-danger-emphasis fw-bold" disabled>
                    Khách hàng: {{ Auth::user()->name ?? '' }}
                </button>
                <button type="button" class="btn btn-sm bg-primary-subtle text-primary fw-bold" disabled>
                    Bộ lọc
                </button>
                <button type="button" class="btn btn-sm bg-primary-subtle text-primary fw-bold" wire:click='filter'>
                    Tất cả
                </button>
                @for ($i = 5; $i >= 0; $i--)
                    <button type="button" class="btn btn-sm bg-warning-subtle text-warning-emphasis"
                        wire:click='filter({{ $i }})'>
                        {{ $i }}
                        <i class="fa-solid fa-star"></i>
                    </button>
                @endfor
                <button type="button" class="btn btn-sm bg-success-subtle text-success fw-bold ms-auto"
                    wire:click='showComment'>
                    <i class="fa-solid fa-comment"></i>
                    Đánh giá sản phẩm
                </button>
            </div>
            <hr>
            <div class="form-control">
                @foreach ($comments as $co)
                    <div class="d-flex gap-2 mb-4">
                        <img src="{{ asset($co->user->img) }}" class="rounded border border-dark" width="42"
                            height="42" alt="logo" />
                        <div class="d-flex flex-column gap-2">
                            <div class="d-flex gap-2">
                                <div class="form-control form-control-sm bg-danger-subtle" style="width:max-content">
                                    <b class="text-danger">{{ $co->user->name }}</b>
                                    <div class="vr"></div>
                                    <b>Đánh giá: </b>
                                    @for ($i = floor($co->star); $i > 0; $i--)
                                        <i class="fa-solid fa-star text-warning-emphasis fa-sm"></i>
                                    @endfor
                                    @for ($i = 5 - floor($co->star); $i > 0; $i--)
                                        <i class="fa-regular fa-star text-warning-emphasis fa-sm"></i>
                                    @endfor
                                </div>
                                @if (Auth::user()->id != $co->user->id)
                                    <button type="button" class="btn btn-sm btn-primary"
                                        wire:click='showComment({{ $co->id }},{{ $co->user->id }})'>
                                        <i class="fa-solid fa-comment"></i>
                                        Trả lời bình luận
                                    </button>
                                @endif
                            </div>


                            <div class="form-control form-control-sm bg-info-subtle">
                                {{ $co->note }}
                            </div>
                        </div>
                    </div>

                    @if ($co->commentChildren->count() > 0)
                        <b>Trả lời</b>
                        <div class="d-flex px-4 mt-2 gap-4">
                            <div class="vr"></div>
                            <div class='w-100'>
                                @foreach ($co->commentChildren as $com)
                                    <div class="d-flex gap-2 mb-4">
                                        <img src="{{ asset($com->user->img) }}" class="rounded border border-dark"
                                            width="42" height="42" alt="logo" />
                                        <div class="d-flex flex-column gap-2">
                                            <div class="d-flex gap-2">
                                                <div class="form-control form-control-sm bg-danger-subtle"
                                                    style="width:max-content">
                                                    <b class="text-danger">{{ $com->user->name }}</b>
                                                </div>
                                                @if ($com->user->is_admin == 1)
                                                    <div class="form-control form-control-sm text-bg-warning"
                                                        style="width:max-content">
                                                        <b>Quản trị viên</b>
                                                    </div>
                                                @endif
                                            </div>

                                            <div class="form-control form-control-sm bg-info-subtle">
                                                {{ $com->note }}
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                @endforeach
                            </div>
                        </div>
                        <button type="button" class="btn btn-sm btn-primary mt-2"
                            wire:click='showComment({{ $co->id }},{{ $co->user->id }})'>
                            <i class="fa-solid fa-comment"></i>
                            Trả lời bình luận
                        </button>
                    @endif
                    <hr>
                @endforeach
                @if ($comments->count() == 0)
                    <div class="form-control bg-danger-subtle text-danger fw-bold">
                        Không có bình luận nào!
                    </div>
                @endif
            </div>

            @if ($event)
                <div class="d-flex align-items-center mt-3 gap-3">

                    @if (!$user)
                        <b>Đánh giá:</b>
                        @for ($i = 1; $i <= 5; $i++)
                            @if ($star[$i - 1] ?? '')
                                <i class="fa-solid fa-star text-warning-emphasis fa-sm"
                                    wire:click='addStar({{ $i }})'></i>
                            @else
                                <i class="fa-regular fa-star text-warning-emphasis fa-sm"
                                    wire:click='addStar({{ $i }})'></i>
                            @endif
                        @endfor
                        <div class="vr"></div>
                    @endif

                    <small><b class="text-danger-emphasis">{{ Auth::user()->name }}</b> trả lời bình luận <b
                            class="text-danger-emphasis">{{ $user->name ?? '' }}</b></small>
                    <button type="button" class="btn btn-sm btn-outline-danger ms-auto"
                        wire:click='showComment'>Đóng</button>
                </div>
                <div class="d-flex gap-3 mt-2">
                    <div class="form-floating" style="width: 100%">
                        <input type="text" class="form-control" id="floatingInput" wire:model='note'
                            placeholder="comment">
                        <label for="floatingInput">Nhập bình luận</label>
                    </div>
                    <button type="button" class="btn btn-primary" wire:click='addComment'>
                        <i class="fa-solid fa-comment"></i>
                        Đăng
                    </button>
                </div>
            @endif
        </div>



        {{--  --}}
        <div class="form-control d-flex flex-column align-items-center gap-2 comment"
            style="width: 20%; height: max-content">
            <h1 class="text-warning">{{ $totalStar }}</h1>
            <div class="d-flex gap-2">
                @for ($i = floor($totalStar); $i > 0; $i--)
                    <i class="fa-solid fa-star text-warning-emphasis"></i>
                @endfor
                @for ($i = 5 - floor($totalStar); $i > 0; $i--)
                    <i class="fa-regular fa-star text-warning-emphasis"></i>
                @endfor
            </div>
            <h6 class="text-warning-emphasis">
                <i class="fa-solid fa-comment"></i>
                {{ count($comments) }} lượt đánh giá
            </h6>
        </div>
    </div>

</div>
