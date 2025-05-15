@extends('admin.layouts.app')

@section('title', 'Quản lý đơn hàng')

@section('content')
<div class="container-fluid">
    <div class="row mb-3">
        <div class="col-12">
            <h1 class="h3 mb-0">Quản lý đơn hàng</h1>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Mã ĐH</th>
                            <th>Khách hàng</th>
                            <th>Ngày đặt</th>
                            <th>Tổng tiền</th>
                            <th>Trạng thái</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($orders as $order)
                        <tr>
                            <td>{{ $order->iddhang }}</td>
                            <td>{{ $order->khachHang->hoten ?? 'N/A' }}</td>
                            <td>{{ $order->ngaydathang }}</td>
                            <td>{{ number_format($order->tongtien) }}đ</td>
                            <td>
                                <span class="badge bg-{{ \App\Models\DonHang::STATUS_CLASSES[$order->trangthai] }}">
                                    {{ \App\Models\DonHang::STATUSES[$order->trangthai] }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('employee.orders.show', $order->iddhang) }}"
                                   class="btn btn-sm btn-info"
                                   title="Chi tiết">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center">Không có đơn hàng nào</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $orders->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
