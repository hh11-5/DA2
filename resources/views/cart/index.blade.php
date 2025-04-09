@extends('layouts.app')

@section('content')
<h2>🛒 Giỏ hàng của bạn</h2>

@if (session('success'))
    <div>{{ session('success') }}</div>
@endif

@if (!empty($cart) && count($cart) > 0)
    <table>
        <tr>
            <th>Tên</th>
            <th>Giá</th>
            <th>Số lượng</th>
            <th>Thành tiền</th>
            <th>Hành động</th>
        </tr>
        @foreach ($cart as $id => $item)
            <tr>
                <td>{{ $item['name'] }}</td>
                <td>{{ number_format($item['price']) }}đ</td>
                <td>
                    <form method="POST" action="{{ route('cart.update', $id) }}">
                        @csrf
                        <input type="number" name="quantity" value="{{ $item['quantity'] }}" min="1">
                        <button type="submit">Cập nhật</button>
                    </form>
                </td>
                <td>{{ number_format($item['price'] * $item['quantity']) }}đ</td>
                <td>
                    <form method="POST" action="{{ route('cart.remove', $id) }}">
                        @csrf
                        <button type="submit">Xoá</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </table>
@else
    <p>Giỏ hàng trống.</p>
@endif
@endsection
