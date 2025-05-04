@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Trang chủ</a></li>
            <li class="breadcrumb-item active">Kết quả tìm kiếm</li>
        </ol>
    </nav>

    <h4 class="mb-4">Kết quả tìm kiếm cho "{{ $query }}"</h4>
    
    @if($products->isEmpty())
        <div class="alert alert-info">
            Không tìm thấy sản phẩm nào phù hợp với từ khóa "{{ $query }}"
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
                            <p class="card-text text-muted">Giá: {{ number_format($product->gia, 0, ',', '.') }}đ</p>
                            <small class="text-muted">{{ $product->nhasanxuat->tennhasx }}</small>
                        </div>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
    @endif
</div>

<style>
.card {
    transition: all 0.3s ease;
    border: none;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}

.card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 16px rgba(0,0,0,0.2);
}

.card-img-top {
    height: 200px;
    object-fit: contain;
    padding: 1rem;
    background-color: #ffffff;
}

.card-body {
    padding: 1.25rem;
}

.card-title {
    font-size: 1rem;
    margin-bottom: 0.5rem;
}
</style>
@endsection