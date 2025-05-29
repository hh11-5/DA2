@extends('admin.layouts.app')

@section('title', 'Chi tiết đơn hàng')

@section('content')
<div class="container-fluid">
    <div class="row mb-3">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h1 class="h3 mb-0">Chi tiết đơn hàng #{{ $order->iddhang }}</h1>
                <a href="{{ route('employee.orders') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Quay lại
                </a>
            </div>
        </div>
    </div>

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <!-- Form cập nhật trạng thái -->
    <div class="card mb-4">
        <div class="card-body">
            <form action="{{ route('employee.orders.update-status', ['iddhang' => $order->iddhang]) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row align-items-end">
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Trạng thái đơn hàng</label>
                        <select name="trangthai" class="form-select status-select" {{ $order->trangthai == 3 || $order->trangthai == 4 ? 'disabled' : '' }}>
                            @if($order->trangthai == 0)
                                <option value="0" selected>Chờ xác nhận</option>
                                <option value="1">Xác nhận đơn hàng</option>
                                <option value="4">Hủy đơn hàng</option>
                            @elseif($order->trangthai == 1)
                                <option value="1" selected>Đã xác nhận</option>
                                <option value="2">Chuyển sang đang giao</option>
                                <option value="4">Hủy đơn hàng</option>
                            @elseif($order->trangthai == 2)
                                <option value="2" selected>Đang giao</option>
                                <option value="3">Đã giao hàng</option>
                                <option value="4">Hủy đơn hàng</option>
                            @elseif($order->trangthai == 3)
                                <option value="3" selected>Đã giao</option>
                            @else
                                <option value="4" selected>Đã hủy</option>
                            @endif
                        </select>
                    </div>
                    <div class="col-md-6">
                        @if($order->trangthai != 3 && $order->trangthai != 4)
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Cập nhật trạng thái
                            </button>
                        @endif
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Thông tin khác của đơn hàng -->
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Sản phẩm trong đơn</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Sản phẩm</th>
                                    <th>Giá</th>
                                    <th>Số lượng</th>
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
                                                 style="width: 50px; height: 50px; object-fit: contain;"
                                                 class="mr-2">
                                            {{ $item->sanPham->tensp }}
                                        </div>
                                    </td>
                                    <td>{{ number_format($item->dongia) }}đ</td>
                                    <td>{{ $item->soluong }}</td>
                                    <td>{{ number_format($item->thanhtien) }}đ</td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="3" class="text-right"><strong>Tổng cộng:</strong></td>
                                    <td><strong>{{ number_format($order->tongtien) }}đ</strong></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Thông tin đơn hàng</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">Thông tin khách hàng</label>
                        <p class="mb-1"><strong>Tên:</strong> {{ $order->khachHang->hokh }} {{ $order->khachHang->tenkh }}</p>
                        <p class="mb-1"><strong>SĐT:</strong> {{ $order->khachHang->taiKhoan->sdttk }}</p>
                        <p class="mb-1"><strong>Địa chỉ:</strong> {{ $order->khachHang->diachikh }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.status-select {
    padding: 0.75rem 1rem;
    font-size: 1rem;
    border-radius: 0.5rem;
    border: 2px solid #e2e8f0;
    background-color: #fff;
    transition: all 0.3s ease;
}

.status-select:focus {
    border-color: #3b82f6;
    box-shadow: 0 0 0 0.2rem rgba(59, 130, 246, 0.25);
    outline: none;
}

.status-select:disabled {
    background-color: #f8fafc;
    cursor: not-allowed;
    opacity: 0.7;
}

.status-select option {
    padding: 0.75rem;
}

/* Styling for different status colors */
.status-select option[value="0"] { color: #f59e0b; } /* Amber for pending */
.status-select option[value="1"] { color: #3b82f6; } /* Blue for confirmed */
.status-select option[value="2"] { color: #8b5cf6; } /* Purple for shipping */
.status-select option[value="3"] { color: #10b981; } /* Green for delivered */
.status-select option[value="4"] { color: #ef4444; } /* Red for cancelled */

/* Button enhancement */
.btn-primary {
    padding: 0.75rem 1.5rem;
    font-weight: 500;
    transition: all 0.3s ease;
}

.btn-primary:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
}

/* Add new styles for back button */
.btn-outline-secondary {
    padding: 0.75rem 1.5rem;
    font-weight: 500;
    transition: all 0.3s ease;
    border: 2px solid #64748b;
    color: #64748b;
}

.btn-outline-secondary:hover {
    background-color: #64748b;
    color: white;
    transform: translateY(-1px);
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
}
</style>
@endsection
