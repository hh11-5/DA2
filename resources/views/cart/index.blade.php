@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2>🛒 Giỏ hàng của bạn</h2>

    @if (!empty($cart) && count($cart) > 0)
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
                        <form method="POST" action="{{ route('cart.update', $id) }}" class="d-flex align-items-center">
                            @csrf
                            <div class="input-group" style="width: 130px;">
                                <button type="button" class="btn btn-outline-secondary btn-sm" onclick="decreaseQty(this)">-</button>
                                <input type="number" name="quantity" value="{{ $item['quantity'] }}" min="1"
                                       class="form-control text-center" required>
                                <button type="button" class="btn btn-outline-secondary btn-sm" onclick="increaseQty(this)">+</button>
                            </div>
                            <button type="submit" class="btn btn-primary btn-sm ms-2">Cập nhật</button>
                        </form>
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

        <div class="text-end mt-3">
            <a href="{{ route('products.index') }}" class="btn btn-secondary">Tiếp tục mua hàng</a>
            <button class="btn btn-primary">Thanh toán</button>
        </div>
    @else
        <div class="alert alert-info">
            Giỏ hàng trống. <a href="{{ route('products.index') }}">Tiếp tục mua hàng</a>
        </div>
    @endif
</div>

<script>
function increaseQty(button) {
    let input = button.parentNode.querySelector('input');
    input.value = parseInt(input.value) + 1;
}

function decreaseQty(button) {
    let input = button.parentNode.querySelector('input');
    let value = parseInt(input.value);
    if (value > 1) {
        input.value = value - 1;
    }
}

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
@endsection
