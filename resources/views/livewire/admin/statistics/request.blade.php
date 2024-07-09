<div class="row mt-3">
    <div class="col-xl-12 request">
        <div class="card shadow mb-4 g-0">
            <div class="card-header py-3">
                <h6 class="m-0 fw-bold text-primary">{{ $title[$event] ?? '' }}</h6>
                <div class="control">
                    <input type="search" wire:model.live.debounce.250ms='search' class="form-control" id='search'
                        placeholder="Nhập tên" />
                    <input type="date" class="form-control" id="before" wire:model.live='before'>
                    <select class="form-select" wire:model.live='limit' aria-label="Default select example">
                        <option value="5">5</option>
                        <option value="10">10</option>
                        <option value="15">15</option>
                    </select>
                    <input type="date" class="form-control" id="after" wire:model.live='after'>
                    <button type="button" class="btn btn-primary" wire:click='Event("")'
                        @if ($event == '') disabled @endif>Tất cả</button>
                    <button type="button" class="btn btn-success" wire:click='Event("confirm")'
                        @if ($event == 'confirm') disabled @endif>Đã duyệt</button>
                    <button type="button" class="btn btn-danger" wire:click='Event("no confirm")'
                        @if ($event == 'no confirm') disabled @endif>Chưa duyệt</button>
                    <button type="button" class="btn btn-primary" wire:click="resetData">
                        <i class="fa-solid fa-repeat"></i>
                    </button>
                </div>
            </div>
            <!-- Card Body -->
            <div class="card-body">
                <table class="table rounded overflow-hidden">
                    <thead class="table-primary">
                        <tr>
                            <th>id</th>
                            <th>Tên</th>
                            <th>Tổng tiền</th>
                            <th>Hình thức tt</th>
                            <th>Trạng thái tt</th>
                            <th>Phí ship</th>
                            <th>Hình thức ship</th>
                            <th>Thời gian</th>
                            <th>Trạng thái</th>
                            <th>Chức năng</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($requestNoConfirm as $order)
                            <tr>
                                <td>{{ $order->id }}</td>
                                <td>{{ $order->user->name }}</td>
                                <td class="text-danger-emphasis fw-bold">{{ $order->grand_total }}</td>
                                <td>
                                    {{ $order->payment_method == 'direct' ? 'Trực tiếp' : 'Vnpay' }}
                                </td>
                                <td>
                                    @if ($order->status != 'cancel')
                                        @if ($order->payment_status == 'waite')
                                            <b class="badge text-danger bg-danger-subtle"
                                                wire:click='payment({{ $order->id }})'>Đang chờ</b>
                                        @else
                                            <b class="badge text-success bg-success-subtle"
                                                wire:click='payment({{ $order->id }})'>Hoàn thành</b>
                                        @endif
                                    @else
                                        <b class="badge text-dark bg-dark-subtle">Đã hủy đơn</b>
                                    @endif
                                </td>
                                <td class="text-danger-emphasis fw-bold">{{ $order->shipping_amout }}</td>
                                <td>
                                    {{ $order->shipping_method == 'fast' ? 'Chuyển phát nhanh' : 'Chuyển phát chậm' }}
                                </td>
                                <td>
                                    {{ $order->created_at ?? '' }}
                                </td>
                                <td>
                                    @if ($order->status == 'no confirm')
                                        <button type="button" class="btn btn-sm btn-warning w-100"
                                            wire:click='confirm({{ $order->id }})'>Duyệt</button>
                                    @elseif ($order->status == 'confirm')
                                        <b class="badge text-success bg-success-subtle">Đã xác nhận</b>
                                    @elseif ($order->status == 'complete')
                                        <b class="badge text-success bg-cuccess-subtle">Hoàn thành</b>
                                    @elseif ($order->status == 'cancel')
                                        <b class="badge text-dark bg-dark-subtle">Đã hủy đơn</b>
                                    @endif
                                </td>
                                <td>
                                    <button type="button" class="btn btn-sm btn-info w-100"
                                        wire:click='show({{ $order->id }})'>Chi tiết</button>
                                </td>
                            </tr>
                        @endforeach
                        @if (count($requestNoConfirm) == 0)
                            <tr class="p-2">
                                <td colspan="10" class="text-danger bg-danger-subtle fw-bold rounded text-center">
                                    Không có yêu cầu nào!
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>

        @if ($showItems)
            <div class="d-sm-flex align-items-center justify-content-between mt-3 mb-3">
                <h1 class="h3 mb-0 fw-bold text-gray-800">Xem chi tiết đơn hàng</h1>
            </div>
            <div class="card shadow mb-4 g-0">
                <div class="card-header py-3">
                    <h6 class="m-0 fw-bold text-primary">Hóa đơn: {{ $orderTitle->user->name }} -
                        {{ $orderTitle->created_at }}
                    </h6>
                    <div class="control">
                        <button type="button" class="btn btn-danger" wire:click="removeItems">
                            <i class="fa-solid fa-close"></i>
                        </button>
                    </div>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                    <table class="table rounded overflow-hidden">
                        <thead class="table-primary">
                            <tr>
                                <th>id</th>
                                <th>Sản phẩm</th>
                                <th>Giá tiền</th>
                                <th>số lượng</th>
                                <th>Tổng tiền</th>
                                <th>Ngày tạo</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($showItems as $item)
                                <tr>
                                    <td>{{ $item->id }}</td>
                                    <td>{{ $item->product->name }}</td>
                                    <td class="text-danger-emphasis fw-bold">{{ $item->unit_amount }}</td>
                                    <td class="text-danger fw-bold">{{ $item->quantity }}</td>
                                    <td class="text-danger-emphasis fw-bold">{{ $item->total_amount }}</td>
                                    <td>{{ $order->created_at ?? '' }}</td>
                                </tr>
                            @endforeach
                            @if (count($showItems) == 0)
                                <tr class="p-2">
                                    <td colspan="10" class="text-danger bg-danger-subtle fw-bold rounded text-center">
                                        Không có sản phẩm nào!
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        @endif
    </div>

    <style>
        .request {
            .card {
                .card-header {
                    display: flex;
                    justify-content: space-between;
                    align-items: center;

                    .control {
                        display: flex;
                        gap: 7px;

                        button,
                        select {
                            width: max-content;
                            white-space: nowrap;
                        }
                    }
                }
            }
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            window.addEventListener('endPage', event => {
                document.body.scrollIntoView({
                    behavior: "smooth",
                    block: "end"
                });
            });
        });
    </script>
</div>
