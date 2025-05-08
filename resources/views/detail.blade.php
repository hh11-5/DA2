@extends('layouts.app')

@section('content')
<style>
    .product-gallery {
        position: relative;
        margin-bottom: 30px;
    }

    .main-image {
        width: 100%;
        height: 400px;
        object-fit: cover;
        border-radius: 10px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }

    .thumbnail-slider {
        margin-top: 20px;
    }

    .thumbnail {
        width: 80px;
        height: 80px;
        object-fit: cover;
        border-radius: 5px;
        cursor: pointer;
        border: 2px solid transparent;
        transition: all 0.3s ease;
    }

    .thumbnail:hover, .thumbnail.active {
        border-color: #475569;
    }

    .product-info h1 {
        color: #1a202c;
        font-size: 2rem;
        margin-bottom: 15px;
    }

    .product-price {
        font-size: 1.8rem;
        color: #dc2626;
        font-weight: bold;
        margin-bottom: 20px;
    }

    .product-specs {
        background: #f8fafc;
        padding: 20px;
        border-radius: 10px;
        margin: 20px 0;
    }

    .spec-item {
        display: flex;
        margin-bottom: 10px;
        border-bottom: 1px solid #e2e8f0;
        padding-bottom: 10px;
    }

    .spec-label {
        width: 150px;
        color: #64748b;
        font-weight: 500;
    }

    .spec-value {
        color: #1a202c;
        flex: 1;
    }

    .buy-buttons {
        display: flex;
        gap: 15px;
        margin: 30px 0;
    }

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
    }

    .btn-add-cart {
        background: #475569;
        color: white;
        padding: 12px 30px;
        border-radius: 8px;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-add-cart:hover {
        background: #334155;
        transform: translateY(-2px);
    }

    .related-products {
        margin-top: 50px;
    }

    .related-products h3 {
        margin-bottom: 20px;
        color: #1a202c;
    }

    /* Card styles */
    .product-card {
        border: none;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        transition: all 0.3s ease;
    }

    .product-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 4px 15px rgba(0,0,0,0.2);
    }

    .card-img-wrapper {
        height: 200px;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: #f8f9fa;
        padding: 1rem;
    }

    .card-img-top {
        height: 100%;
        width: auto;
        object-fit: contain;
        transition: transform 0.3s ease;
    }

    .product-card:hover .card-img-top {
        transform: scale(1.05);
    }

    .card-title {
        font-size: 1rem;
        margin-bottom: 0.5rem;
        height: 2.4rem;
        overflow: hidden;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
    }

    .card-footer {
        padding: 1rem;
        background: transparent;
    }

    .card-footer .btn {
        font-size: 0.875rem;
        padding: 0.25rem 0.5rem;
    }

    .card-footer form {
        margin: 0;
    }

    /* Related products section */
    .related-products {
        margin-top: 4rem;
        padding-top: 2rem;
        border-top: 1px solid #e2e8f0;
    }

    .related-products h3 {
        margin-bottom: 2rem;
        color: #1a202c;
        font-size: 1.5rem;
        font-weight: 600;
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .row-cols-md-4 > * {
            width: 50%;
        }

        .card-footer {
            flex-direction: column;
            gap: 0.5rem;
        }

        .card-footer .btn {
            width: 100%;
        }
    }
</style>

<div class="container mt-5">
    <div class="row">
        <!-- Gallery -->
        <div class="col-md-6">
            <div class="product-gallery">
                <img src="{{ asset($sanpham->hinhsp) }}" class="main-image" id="mainImage" alt="{{ $sanpham->tensp }}">

                <div class="thumbnail-slider d-flex gap-2 mt-3">
                    @foreach($images as $image)
                    <img src="{{ asset($image) }}"
                         class="thumbnail"
                         onclick="changeMainImage(this.src)"
                         alt="Thumbnail">
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Product Info -->
        <div class="col-md-6">
            <div class="product-info">
                <h1>{{ $sanpham->tensp }}</h1>
                <div class="product-price">
                    {{ number_format($sanpham->gia, 0, ',', '.') }}đ
                </div>

                <div class="product-specs">
                    <div class="spec-item">
                        <span class="spec-label">Thương hiệu:</span>
                        <span class="spec-value">{{ $sanpham->nhasanxuat->tennhasx }}</span>
                    </div>
                    <div class="spec-item">
                        <span class="spec-label">Xuất xứ:</span>
                        <span class="spec-value">{{ $sanpham->xuatxu }}</span>
                    </div>
                    <div class="spec-item">
                        <span class="spec-label">Kiểu:</span>
                        <span class="spec-value">{{ $sanpham->kieu }}</span>
                    </div>
                    <div class="spec-item">
                        <span class="spec-label">Chất liệu vỏ:</span>
                        <span class="spec-value">{{ $sanpham->clieuvo }}</span>
                    </div>
                    <div class="spec-item">
                        <span class="spec-label">Đường kính:</span>
                        <span class="spec-value">{{ $sanpham->clieukinh }}</span>
                    </div>
                    <div class="spec-item">
                        <span class="spec-label">Chống nước:</span>
                        <span class="spec-value">{{ $sanpham->khangnuoc }}</span>
                    </div>
                    <div class="spec-item">
                        <span class="spec-label">Bảo hành:</span>
                        <span class="spec-value">{{ $sanpham->tgbaohanh_nam }} năm</span>
                    </div>
                </div>

                <div class="buy-buttons">
                    <button class="btn btn-buy-now">MUA NGAY</button>
                    <form action="{{ route('cart.add', $sanpham->idsp) }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-add-cart">
                            <i class="fas fa-shopping-cart me-2"></i>THÊM VÀO GIỎ
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Related Products -->
    <div class="related-products">
        <h3>Sản phẩm cùng thương hiệu</h3>
        <div class="row row-cols-2 row-cols-md-4 g-4">
            @foreach($relatedProducts as $product)
            <div class="col">
                <a href="{{ route('products.show', $product->idsp) }}" class="text-decoration-none">
                    <div class="card product-card h-100">
                        <div class="card-img-wrapper">
                            <img src="{{ asset($product->hinhsp) }}" class="card-img-top" alt="{{ $product->tensp }}">
                        </div>
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title text-dark">{{ $product->tensp }}</h5>
                            <div class="text-danger fw-bold mt-auto">
                                {{ number_format($product->gia, 0, ',', '.') }}đ
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
    </div>
</div>

<script>
function changeMainImage(src) {
    document.getElementById('mainImage').src = src;
    document.querySelectorAll('.thumbnail').forEach(thumb => {
        thumb.classList.remove('active');
    });
    event.target.classList.add('active');
}
</script>
@endsection
