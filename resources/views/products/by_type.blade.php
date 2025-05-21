
@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Trang chủ</a></li>
            <li class="breadcrumb-item active">{{ $type }}</li>
        </ol>
    </nav>

    <h4 class="mb-4">{{ $type }}</h4>

    @if($products->isEmpty())
        <div class="alert alert-info">
            Không tìm thấy sản phẩm nào thuộc loại này
        </div>
    @else
        <div class="row row-cols-2 row-cols-md-4 g-4">
            @foreach($products as $product)
            <div class="col">
                <a href="{{ route('products.show', $product->idsp) }}" class="text-decoration-none">
                    <div class="card h-100">
                        <img src="{{ asset($product->hinhsp) }}" class="card-img-top" alt="{{ $product->tensp }}">
                        <div class="card-body">
                            <h5 class="card-title text-dark">{{ $product->tensp }}</h5>
                            <p class="card-text product-price">
                                {{ number_format($product->gia, 0, ',', '.') }}đ
                            </p>
                        </div>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
    @endif
</div>
@endsection