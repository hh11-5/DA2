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
                            <span class="badge bg-{{ $order->trangthai === 'Đã hủy' ? 'danger' :
                                ($order->trangthai === 'Đã giao' ? 'success' : 'info') }}">
                                {{ $order->trangthai }}
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
        </div>
    @endif
</div>
@endsection
