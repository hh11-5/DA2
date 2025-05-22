@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2>Lịch sử đơn hàng</h2>

    @if($orders->isEmpty())
        <div class="alert alert-info">
            Bạn chưa có đơn hàng nào.
        </div>
    @else
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Mã đơn hàng</th>
                        <th>Ngày đặt</th>
                        <th>Tổng tiền</th>
                        <th>Phí vận chuyển</th>
                        <th>Trạng thái</th>
                        <th>Chi tiết</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $order)
                    <tr>
                        <td>{{ $order->iddhang }}</td>
                        <td>{{ $order->ngaydathang->format('d/m/Y H:i') }}</td>
                        <td>{{ number_format($order->tongtien) }}đ</td>
                        <td>{{ number_format($order->phivanchuyen) }}đ</td>
                        <td>
                            @php
                                $statusClass = [
                                    0 => 'secondary',  // Chờ xác nhận
                                    1 => 'info',       // Đã xác nhận
                                    2 => 'primary',    // Đang giao
                                    3 => 'success',    // Đã giao
                                    4 => 'danger'      // Đã hủy
                                ];
                                $statusText = [
                                    0 => 'Chờ xác nhận',
                                    1 => 'Đã xác nhận',
                                    2 => 'Đang giao',
                                    3 => 'Đã giao',
                                    4 => 'Đã hủy'
                                ];
                            @endphp
                            <span class="badge bg-{{ $statusClass[$order->trangthai] }}">
                                {{ $statusText[$order->trangthai] }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('orders.show', $order->iddhang) }}"
                               class="btn btn-sm btn-outline-primary">
                                Xem chi tiết
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            @if($orders->hasPages())
                <div class="mt-4">
                    {{ $orders->links() }}
                </div>
            @endif
        </div>
    @endif
</div>

<style>
.badge {
    padding: 8px 12px;
    font-weight: 500;
}
.table > tbody > tr > td {
    vertical-align: middle;
}
</style>
@endsection
