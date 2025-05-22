@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2>🛒 Giỏ hàng của bạn</h2>
    @if (!empty($cart) && count($cart) > 0)
        <!-- Thêm biến để kiểm tra có sản phẩm hết hàng không -->
        @php
            $hasOutOfStock = false;
            foreach($cart as $item) {
                if($item['tonkho'] <= 0) {
                    $hasOutOfStock = true;
                    break;
                }
            }
        @endphp

        <table class="table table-hover">
            <tr>
                <th>Tên</th>
                <th>Hình ảnh</th>
                <th>Giá</th>
                <th>Số lượng</th>
                <th>Thành tiền</th>
                <th>Hành động</th>
            </tr>
            @foreach ($cart as $id => $item)
                <tr>
                    <td>{{ $item['tensp'] }}</td>
                    <td>
                        <img src="{{ asset($item['hinhsp']) }}" alt="{{ $item['tensp'] }}" style="width: 100px">
                    </td>
                    <td>{{ number_format($item['gia']) }}đ</td>
                    <td>
                        <form method="POST" action="{{ route('cart.update', $id) }}" class="d-flex align-items-center" data-product-id="{{ $id }}">
                            @csrf
                            <div class="input-group" style="width: 130px;">
                                <button type="button" class="btn btn-outline-secondary btn-sm" onclick="decreaseQty(this)">-</button>
                                <input type="number" name="quantity"
                                       value="{{ $item['quantity'] }}"
                                       min="1"
                                       max="{{ $item['tonkho'] }}"
                                       class="form-control text-center"
                                       required
                                       data-tonkho="{{ $item['tonkho'] }}">
                                <button type="button" class="btn btn-outline-secondary btn-sm" onclick="increaseQty(this)">+</button>
                            </div>
                        </form>
                        @if($item['tonkho'] <= 0)
                            <span class="badge bg-danger">Hết hàng</span>
                        @elseif($item['tonkho'] <= 10)
                            <small class="text-danger d-block mt-1">
                                Chỉ còn {{ $item['tonkho'] }} sản phẩm
                            </small>
                        @endif
                    </td>
                    <td>{{ number_format($item['gia'] * $item['quantity']) }}đ</td>
                    <td>
                        <form method="POST" action="{{ route('cart.remove', $id) }}">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-danger">Xoá</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            <tr>
                <td colspan="4" class="text-end"><strong>Tổng cộng:</strong></td>
                <td><strong>{{ number_format($total) }}đ</strong></td>
                <td></td>
            </tr>
        </table>

        <!-- Phần nút thanh toán -->
        <div class="text-end mt-3">
            <a href="{{ route('products.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-2"></i>Tiếp tục mua hàng
            </a>
            @if($hasOutOfStock)
                <button class="btn btn-buy-now" disabled title="Có sản phẩm đã hết hàng">
                    <i class="fas fa-exclamation-circle me-2"></i>Không thể thanh toán
                </button>
            @else
                <a href="{{ route('checkout.index') }}" class="btn btn-buy-now">
                    <i class="fas fa-check me-2"></i>Thanh toán
                </a>
            @endif
        </div>
    @else
        <div class="alert alert-info">
            Giỏ hàng trống. <a href="{{ route('products.index') }}">Tiếp tục mua hàng</a>
        </div>
    @endif
</div>

<script>
function increaseQty(button) {
    const form = button.closest('form');
    const input = form.querySelector('input[name="quantity"]');
    const tonKho = parseInt(input.dataset.tonkho);

    if (input && parseInt(input.value) < tonKho) {
        input.value = parseInt(input.value) + 1;
        form.submit();
    } else {
        alert('Số lượng đặt hàng không thể vượt quá số lượng tồn kho!');
    }
}

function decreaseQty(button) {
    const form = button.closest('form');
    const input = form.querySelector('input[name="quantity"]');
    if (input && parseInt(input.value) > 1) {
        input.value = parseInt(input.value) - 1;
        form.submit();
    }
}

// Kiểm tra khi người dùng nhập trực tiếp số lượng
document.addEventListener('DOMContentLoaded', function() {
    const quantityInputs = document.querySelectorAll('input[name="quantity"]');
    quantityInputs.forEach(input => {
        input.addEventListener('change', function() {
            const tonKho = parseInt(this.dataset.tonkho);
            let value = parseInt(this.value);

            if (value < 1) {
                this.value = 1;
            } else if (value > tonKho) {
                alert('Số lượng đặt hàng không thể vượt quá số lượng tồn kho!');
                this.value = tonKho;
            }
            this.closest('form').submit();
        });
    });
});

// Tự động ẩn thông báo sau 3 giây
window.addEventListener('load', function() {
    setTimeout(function() {
        document.querySelectorAll('.alert').forEach(function(alert) {
            if (alert) {
                alert.classList.remove('show');
                setTimeout(function() {
                    alert.remove();
                }, 150);
            }
        });
    }, 3000);
});
</script>

<style>
.btn-buy-now {
    background: #fbbf24;
    color: #1a202c;
    padding: 12px 30px;
    border-radius: 8px;
    font-weight: 600;
    transition: all 0.3s ease;
}

.btn-buy-now:hover {
    background: #f59e0b;
    transform: translateY(-2px);
    color: #1a202c;
}

.btn-buy-now:disabled {
    background: #cbd5e1;
    cursor: not-allowed;
    transform: none;
}

.btn-outline-secondary {
    border-radius: 8px;
    padding: 12px 12px;
    font-weight: 600;
    transition: all 0.3s ease;
}

.btn-outline-secondary:hover {
    transform: translateY(-2px);
}

.text-danger {
    font-size: 0.875rem;
}

.badge {
    padding: 0.5em 0.75em;
    font-weight: 500;
}

/* Highlight input khi vượt quá tồn kho */
input[name="quantity"]:invalid {
    border-color: #dc3545;
    box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);
}
</style>
@endsection
