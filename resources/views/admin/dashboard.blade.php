@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="row">
    @if(Auth::user()->phanQuyen->idqh == 1)
    <!-- Admin Dashboard -->
    <div class="col-lg-6 col-12">
        <div class="small-box bg-info">
            <div class="inner">
                <h3>{{ $todayProducts ?? 0 }}</h3>
                <p>Sản phẩm đã bán hôm nay</p>
            </div>
            <div class="icon">
                <i class="fas fa-shopping-cart"></i>
            </div>
        </div>
    </div>
    <div class="col-lg-6 col-12">
        <div class="small-box bg-success">
            <div class="inner">
                <h3>{{ number_format($todayRevenue ?? 0) }}đ</h3>
                <p>Doanh thu hôm nay</p>
                <a href="{{ route('admin.statistics') }}?type=daily" class="text-white">
                    <small><i class="fas fa-arrow-circle-right"></i> Xem chi tiết ngay</small>
                </a>
            </div>
            <div class="icon">
                <i class="fas fa-chart-line"></i>
            </div>
        </div>
    </div>
    @endif
    @if(Auth::user()->phanQuyen->idqh == 2)
    <!-- Admin Dashboard -->
    <div class="col-lg-6 col-12">
        <div class="small-box bg-info">
            <div class="inner">
                <h3>{{ $pendingOrders ?? 0 }}</h3>
                <p>Đơn hàng đang chờ xác nhận</p>
                <a href="{{ route('employee.orders') }}" class="text-white">
                    <small><i class="fas fa-arrow-circle-right"></i> Xem chi tiết ngay</small>
                </a>
            </div>
            <div class="icon">
                <i class="fas fa-shopping-cart"></i>
            </div>
        </div>
    </div>
    <div class="col-lg-6 col-12">
        <div class="small-box bg-success">
            <div class="inner">
                <h3>{{ number_format($todayRevenue ?? 0) }}đ</h3>
                <p>Doanh thu hôm nay</p>
                <a href="{{ route('employee.statistics') }}?type=daily" class="text-white">
                    <small><i class="fas fa-arrow-circle-right"></i> Xem chi tiết ngay</small>
                </a>
            </div>
            <div class="icon">
                <i class="fas fa-chart-line"></i>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection
