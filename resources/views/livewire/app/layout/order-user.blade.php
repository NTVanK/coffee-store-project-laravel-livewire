<div class="form-control order-user py-3">
    <div class="d-flex">
        <h4>Đơn hàng của tôi</h4>
        <button class="btn btn-sm btn-success ms-auto" style="height: max-content">x</button>
    </div>
    <hr>
    <table class="table rounded overflow-hidden">
        <thead class="table-primary">
            <tr>
                <th>Tổng tiền</th>
                <th>Hình thức tt</th>
                <th>Trạng thái tt</th>
                <th>Trạng thái</th>
                <th>Phí ship</th>
                <th>Hình thức ship</th>
                <th>Thời gian</th>
                <th>Chức năng</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($orders as $order)
                <tr>
                    <td class="text-danger-emphasis fw-bold">{{ $order->grand_total }}</td>
                    <td>
                        {{ $order->payment_method == 'direct' ? 'Trực tiếp' : 'Vnpay' }}
                    </td>
                    <td>
                        @if ($order->status != 'cancel')
                            @if ($order->payment_status == 'waite')
                                <b class="badge text-danger bg-danger-subtle">Đang chờ</b>
                            @else
                                <b class="badge text-success bg-success-subtle">Hoàn thành</b>
                            @endif
                        @elseif($order->status == 'complete')
                            <b class="badge text-success bg-success-subtle">Hoàn thành</b>
                        @else
                            <b class="badge text-dark bg-dark-subtle">Đã hủy đơn</b>
                        @endif
                    </td>
                    <td>
                        @if ($order->status == 'no confirm')
                            <b class="badge text-warning bg-warning-subtle">Chờ xác nhận</b>
                        @elseif ($order->status == 'confirm')
                            <b class="badge text-danger bg-danger-subtle">Đã xác nhận</b>
                        @elseif ($order->status == 'complete')
                            <b class="badge text-success bg-success-subtle">Hoàn thành</b>
                        @elseif ($order->status == 'cancel')
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
                    <td class="d-flex flex-column gap-1">
                        @if ($order->status == 'no confirm')
                            <button type="button" class="btn btn-sm btn-danger w-100"
                                wire:click='cancel({{ $order->id }})'>Hủy</button>
                        @endif
                        <button type="button" class="btn btn-sm btn-info w-100"
                            wire:click='show({{ $order->id }})'>Chi tiết</button>
                    </td>
                </tr>
            @endforeach
            @if (count($orders) == 0)
                <tr class="p-2">
                    <td colspan="10" class="text-danger bg-danger-subtle fw-bold rounded text-center">
                        Không có hóa đơn nào!
                    </td>
                </tr>
            @endif
        </tbody>
    </table>
    @if ($showItems)
        <hr>
        <div class="d-sm-flex align-items-center justify-content-between mt-3">
            <h4>Xem chi tiết đơn hàng</h4>
        </div>
        <div class="card shadow mb-4 g-0">
            <div class="card-header d-flex py-3">
                <h6 class="m-0 fw-bold text-primary">Hóa đơn: {{ $orderTitle->user->name }} -
                    {{ $orderTitle->created_at }}
                </h6>
                <button type="button" class="btn btn-sm btn-danger ms-auto" wire:click="removeItems">
                    <i class="fa-solid fa-close"></i>
                </button>
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
