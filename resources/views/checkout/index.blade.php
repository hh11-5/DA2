@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="row">
        <!-- Bên trái: Danh sách sản phẩm -->
        <div class="col-md-8">
            <!-- Thông tin khách hàng -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">THÔNG TIN KHÁCH HÀNG</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">Họ tên:</label>
                        <input type="text" class="form-control" value="{{ $customer->hokh }} {{ $customer->tenkh }}" readonly>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Số điện thoại:</label>
                        <input type="text" class="form-control" value="{{ Auth::user()->sdttk }}" readonly>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Địa chỉ:</label>
                        <input type="text" class="form-control" value="{{ $customer->diachikh }}" readonly>
                    </div>
                </div>
            </div>

            <!-- Danh sách sản phẩm -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">THÔNG TIN SẢN PHẨM</h5>
                </div>
                <div class="card-body">
                    @foreach($items as $item)
                    <div class="d-flex align-items-center mb-3">
                        <img src="{{ asset($item['hinhsp']) }}" alt="{{ $item['tensp'] }}" style="width: 80px; margin-right: 15px;">
                        <div class="flex-grow-1">
                            <h6 class="mb-0">{{ $item['tensp'] }}</h6>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="text-muted">{{ number_format($item['gia']) }}đ x {{ $item['soluong'] }}</span>
                                <span class="fw-bold">{{ number_format($item['total']) }}đ</span>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Bên phải: Thông tin thanh toán -->
        <div class="col-md-4">
            <!-- Thông tin đơn hàng -->
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">THÔNG TIN ĐƠN HÀNG</h5>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-2">
                        <span>Tạm tính ({{ count($items) }} sản phẩm):</span>
                        <span>{{ number_format($subtotal) }}đ</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Giảm giá:</span>
                        <span>Liên hệ</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Phí vận chuyển:</span>
                        <span>
                            @if($shipping == 0)
                                <span class="text-success">Miễn phí vận chuyển</span>
                            @else
                                {{ number_format($shipping) }}đ
                            @endif
                        </span>
                    </div>
                    <small class="text-muted d-block mb-2">
                    </small>
                    <hr>
                    <div class="d-flex justify-content-between mb-2">
                        <strong>Tổng cộng:</strong>
                        <strong class="text-danger">{{ number_format($grandTotal) }}đ</strong>
                    </div>
                    <small class="text-muted">Giá đã bao gồm VAT</small>

                    <div class="mt-3">
                        <form action="{{ route('checkout.process') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-danger w-100">ĐẶT HÀNG</button>
                        </form>
                        <a href="{{ route('cart.index') }}" class="btn btn-outline-secondary w-100 mt-2">Quay lại giỏ hàng</a>
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
.btn-danger {
    background-color: #dc3545;
    border-color: #dc3545;
}
</style>
@endsection
