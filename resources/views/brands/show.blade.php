@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Trang chủ</a></li>
            <li class="breadcrumb-item active">{{ $brand->tennhasx }}</li>
        </ol>
    </nav>

    <h2 class="mb-4">Đồng hồ {{ $brand->tennhasx }}</h2>
    
    <div class="row row-cols-2 row-cols-md-3 g-4">
        @forelse($products as $product)
        <div class="col">
            <a href="{{ route('products.show', $product->idsp) }}" class="text-decoration-none">
                <div class="card h-100">
                    <img src="{{ asset($product->hinhsp) }}" class="card-img-top" alt="{{ $product->tensp }}">
                    <div class="card-body">
                        <h5 class="card-title text-dark">{{ $product->tensp }}</h5>
                        <p class="card-text text-muted">Giá: {{ number_format($product->gia, 0, ',', '.') }}đ</p>
                    </div>
                </div>
            </a>
        </div>
        @empty
        <div class="col-12">
            <div class="alert alert-info">
                Hiện chưa có sản phẩm nào của thương hiệu {{ $brand->tennhasx }}
            </div>
        </div>
        @endforelse
    </div>
</div>

<style>
.card {
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease;
}

.card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.15);
}

.card-img-top {
    height: 220px;
    object-fit: contain;
    padding: 1rem;
    background-color: #ffffff;
}

.breadcrumb-item a {
    color: #475569;
    text-decoration: none;
}

.breadcrumb-item a:hover {
    color: #2b6cb0;
}
</style>
@endsection