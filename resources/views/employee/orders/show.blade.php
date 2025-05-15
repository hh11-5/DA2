@extends('admin.layouts.app')

@section('title', 'Chi tiết đơn hàng')

@section('content')
<div class="container-fluid">
    <div class="row mb-3">
        <div class="col-12">
            <h1 class="h3 mb-0">Chi tiết đơn hàng #{{ $order->iddh }}</h1>
        </div>
    </div>

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

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
                                    <td>{{ number_format($item->gia) }}đ</td>
                                    <td>{{ $item->soluong }}</td>
                                    <td>{{ number_format($item->gia * $item->soluong) }}đ</td>
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
                    <form action="{{ route('employee.orders.update-status', $order->iddh) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label class="form-label">Trạng thái đơn hàng</label>
                            <select name="trangthai" class="form-select" {{ $order->trangthai == 3 || $order->trangthai == 4 ? 'disabled' : '' }}>
                                <option value="0" {{ $order->trangthai == 0 ? 'selected' : '' }}>Đang xử lý</option>
                                <option value="1" {{ $order->trangthai == 1 ? 'selected' : '' }}>Đã xác nhận</option>
                                <option value="2" {{ $order->trangthai == 2 ? 'selected' : '' }}>Đang giao</option>
                                <option value="3" {{ $order->trangthai == 3 ? 'selected' : '' }}>Đã giao</option>
                                <option value="4" {{ $order->trangthai == 4 ? 'selected' : '' }}>Đã hủy</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Thông tin khách hàng</label>
                            <p class="mb-1"><strong>Tên:</strong> {{ $order->khachHang->hoten }}</p>
                            <p class="mb-1"><strong>SĐT:</strong> {{ $order->khachHang->sdt }}</p>
                            <p class="mb-1"><strong>Địa chỉ:</strong> {{ $order->khachHang->diachi }}</p>
                        </div>

                        @if($order->trangthai != 3 && $order->trangthai != 4)
                            <button type="submit" class="btn btn-primary">
                                Cập nhật trạng thái
                            </button>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
