<div class="form-control px-4 py-3" style="height: max-content">
    <div class="d-flex gap-2" style="height: max-content">
        <select class="form-select" style="width: 30%" wire:model.live='product_id' aria-label="Default select example">
            <option selected>Chọn sản phẩm</option>
            @foreach ($products as $pro)
                <option value="{{$pro->id}}">{{$pro->name}}</option>
            @endforeach
        </select>
        <button type="button" class="btn bg-primary-subtle text-primary fw-bold" wire:click='filter'>
            Tất cả
        </button>
        @for ($i = 5; $i >= 0; $i--)
            <button type="button" class="btn bg-warning-subtle text-warning-emphasis"
                wire:click='filter({{ $i }})'>
                {{ $i }}
                <i class="fa-solid fa-star"></i>
            </button>
        @endfor
    </div>
    @if ($event)
        <div class="d-flex align-items-center mt-3 gap-3">
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
    <div class="form-control mt-2" style="height: max-content">
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
                                        @if($com->user->is_admin == 1)
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
        @if($comments->count() == 0)
            <div class="form-control bg-danger-subtle text-danger fw-bold">
                Không có bình luận nào!
            </div>
        @endif
    </div>
</div>
