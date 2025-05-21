@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="row">
        <div class="col-12 mb-3">
            <div class="d-flex justify-content-between align-items-center">
                <h2>Chi tiết đơn hàng #{{ $order->iddhang }}</h2>
                <a href="{{ route('orders.history') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Quay lại
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Thông tin đơn hàng -->
        <div class="col-md-4 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Thông tin đơn hàng</h5>
                </div>
                <div class="card-body">
                    <p><strong>Ngày đặt:</strong> {{ $order->ngaydathang->format('d/m/Y H:i') }}</p>
                    <p><strong>Trạng thái:</strong>
                        @php
                            $statusClass = [
                                0 => 'secondary',
                                1 => 'info',
                                2 => 'primary',
                                3 => 'success',
                                4 => 'danger'
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
                    </p>
                    <p><strong>Tạm tính:</strong> {{ number_format($order->tongtien - $order->phivanchuyen) }}đ</p>
                    <p><strong>Phí vận chuyển:</strong> {{ number_format($order->phivanchuyen) }}đ</p>
                    <p class="mb-0"><strong>Tổng cộng:</strong>
                        <span class="text-danger fs-5">{{ number_format($order->tongtien) }}đ</span>
                    </p>
                </div>
            </div>
        </div>

        <!-- Thông tin người nhận -->
        <div class="col-md-4 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Thông tin người nhận</h5>
                </div>
                <div class="card-body">
                    <p><strong>Họ tên:</strong> {{ $order->khachHang->hokh }} {{ $order->khachHang->tenkh }}</p>
                    <p><strong>Số điện thoại:</strong> {{ $order->khachHang->taiKhoan->sdttk ?? 'Chưa cập nhật' }}</p>
                    <p class="mb-0"><strong>Địa chỉ:</strong> {{ $order->khachHang->diachikh }}</p>
                </div>
            </div>
        </div>

        <!-- Chi tiết sản phẩm -->
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Chi tiết sản phẩm</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Sản phẩm</th>
                                    <th>Giá</th>
                                    <th>Số lượng</th>
                                    <th>Giảm giá</th>
                                    <th>Thành tiền</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order->chiTietDonHang as $item)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="{{ asset($item->sanPham->hinhsp) }}"
                                                 alt="{{ $item->sanPham->tensp }}"
                                                 class="me-3"
                                                 style="width: 50px; height: 50px; object-fit: contain;">
                                            <div>
                                                <h6 class="mb-0">{{ $item->sanPham->tensp }}</h6>
                                                <small class="text-muted">{{ $item->sanPham->masp }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ number_format($item->dongia) }}đ</td>
                                    <td>{{ $item->soluong }}</td>
                                    <td>{{ number_format($item->giamgia) }}đ</td>
                                    <td>{{ number_format($item->thanhtien) }}đ</td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="4" class="text-end"><strong>Tạm tính:</strong></td>
                                    <td>{{ number_format($order->tongtien - $order->phivanchuyen) }}đ</td>
                                </tr>
                                <tr>
                                    <td colspan="4" class="text-end"><strong>Phí vận chuyển:</strong></td>
                                    <td>{{ number_format($order->phivanchuyen) }}đ</td>
                                </tr>
                                <tr>
                                    <td colspan="4" class="text-end"><strong>Tổng cộng:</strong></td>
                                    <td><strong class="text-danger">{{ number_format($order->tongtien) }}đ</strong></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.card {
    border-radius: 8px;
    box-shadow: 0 1px 3px rgba(0,0,0,0.1);
}

.card-header {
    background-color: #f8f9fa;
    border-bottom: 1px solid #eee;
}

.badge {
    padding: 6px 10px;
    font-weight: 500;
}

.table > :not(caption) > * > * {
    padding: 1rem;
}
</style>
@endsection
