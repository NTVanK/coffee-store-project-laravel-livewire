<div class="row" wire:poll.keep-alive>
    <div class="col-xl-8 col-lg-7">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Tổng quan thu nhập (trong vòng 4 tháng)</h6>
                <div class="d-flex gap-2">
                    <button type="button" class="btn btn-primary"><i class="fa-solid fa-repeat"></i></button>
                    <input type="date" class="form-control" wire:model.live='date'>
                </div>
            </div>
            <!-- Card Body -->
            <div class="card-body">
                <div class="d-flex bg-primary px-2 py-1 mb-3 rounded">
                    <div class="text-light" style="width: 20%">0</div>
                    <div class="text-light" style="width: 20%">1,000,000</div>
                    <div class="text-light" style="width: 20%">2,000,000</div>
                    <div class="text-light" style="width: 20%">3,000,000</div>
                    <div class="text-light" style="width: 20%">4,000,000</div>
                </div>

                @php
                    function percent($total)
                    {
                        if ($total != 0) {
                            $percent = $total / (5000000 * 0.01);
                        }

                        return $percent ?? 0;
                    }
                @endphp

                @foreach ($fiveMonth as $key => $item)
                    <h4 class="small font-weight-bold"> {{ $key }} <span
                            class="float-right">{{ $item[0] }} (VND)</span></h4>
                    <div class="progress mb-1">
                        <div class="progress-bar bg-primary" role="progressbar" style="width: {{ percent($item[0]) }}%"
                            aria-valuenow="{{ percent($item[0]) }}" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <div class="progress">
                        <div class="progress-bar bg-danger" role="progressbar" style="width: {{ percent($item[1]) }}%"
                            aria-valuenow="{{ percent($item[1]) }}" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <div class="text-end">
                        <small class="float-end fw-bold w-100">{{ $item[1] }} (VND)</small>
                    </div>
                    <hr>
                @endforeach
            </div>
        </div>
    </div>

    <div class="col-xl-4 col-lg-5">
        <div class="card shadow mb-4">
            <!-- Card Header - Dropdown -->
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Bình luận sản phẩm</h6>
                <a href="{{ route('admin.comment') }}" wire:navigate class="btn btn-sm btn-primary">
                    Xem
                </a>
            </div>
            <!-- Card Body -->
            <div class="card-body">
                <div class="pt-1 text-title overflow-y-scroll">
                    @foreach ($comments as $co)
                        <div class="d-flex gap-2 mb-4">
                            <img src="{{ asset($co->user->img) }}" class="rounded border border-dark" width="42"
                                height="42" alt="logo" />
                            <div class="d-flex flex-column gap-2">
                                <div class="text-danger text-name">{{ $co->product->name }}</div>
                                <div class="d-flex gap-2">
                                    <div class="form-control form-control-sm bg-danger-subtle"
                                        style="80%">
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
                                </div>
                                <div class="form-control form-control-sm bg-info-subtle">
                                    {{ $co->note }}
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="mt-4 text-center small">
                    <span class="mr-2">
                        <i class="fas fa-circle text-primary"></i> Direct
                    </span>
                    <span class="mr-2">
                        <i class="fas fa-circle text-success"></i> Social
                    </span>
                    <span class="mr-2">
                        <i class="fas fa-circle text-info"></i> Referral
                    </span>
                </div>
            </div>
        </div>
    </div>

    <style>
        .text-title{
            height: 380px;
        }
        .text-name{
            width: 350px;
            white-space:nowrap;
            max-width: 100%;
            overflow: hidden;
            text-overflow: ellipsis;
            font-weight: bold;
        }
    </style>
</div>
