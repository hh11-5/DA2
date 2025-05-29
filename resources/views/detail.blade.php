@extends('layouts.app')

@section('content')
<style>
    /* Điều chỉnh gallery và hình ảnh chính */
    .product-gallery {
        position: relative;
        margin-bottom: 30px;
        overflow: hidden;
    }

    .main-image-wrapper {
        position: relative;
        overflow: hidden;
        border-radius: 15px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.1);
        background: white;
        padding: 20px;
    }

    .main-image {
        width: 100%;
        height: 350px; /* Giảm chiều cao xuống */
        object-fit: contain; /* Đảm bảo ảnh không bị méo */
        transition: transform 0.3s ease;
    }

    .main-image-wrapper:hover .main-image {
        transform: scale(1.1);
    }

    /* Điều chỉnh thumbnails */
    .thumbnail {
        width: 80px;
        height: 80px;
        object-fit: contain;
        border-radius: 10px;
        cursor: pointer;
        border: 2px solid transparent;
        transition: all 0.3s ease;
        background: white;
        padding: 0.5rem;
        box-shadow: 0 2px 8px rgba(0,0,0,0.05);
    }

    .thumbnail:hover, .thumbnail.active {
        border-color: #3b82f6;
        transform: translateY(-2px);
    }

    .product-info h1 {
        color: #1e293b;
        font-size: 2rem;
        font-weight: 700;
        margin-bottom: 20px;
        line-height: 1.3;
    }

    .product-price {
        position: relative;
        display: inline-block;
        padding: 12px 25px;
        background: linear-gradient(45deg, #ffede6, #fff1f0);
        color: #ff4d4d;
        font-size: 1.5rem;
        font-weight: 600;
        border-radius: 12px;
        margin-bottom: 20px;
        border: 1px solid rgba(255, 77, 77, 0.2);
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        box-shadow: 0 4px 15px rgba(255, 77, 77, 0.1);
    }

    .product-price:hover {
        background: linear-gradient(45deg, #fff1f0, #ffede6);
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(255, 77, 77, 0.15);
        border-color: rgba(255, 77, 77, 0.3);
    }

    /* Thay thế animation float bằng shine effect */
    .product-price::after {
        content: '';
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: linear-gradient(
            45deg,
            transparent,
            rgba(255, 255, 255, 0.4),
            transparent
        );
        transform: rotate(45deg);
        transition: all 0.5s ease;
        opacity: 0;
    }

    .product-price:hover::after {
        opacity: 1;
        transform: rotate(45deg) translate(50%, 50%);
    }

    .product-specs {
        background: linear-gradient(145deg, #ffffff, #f8fafc);
        box-shadow: 0 2px 15px rgba(0,0,0,0.08);
        padding: 30px;
        border-radius: 20px;
        margin: 25px 0;
        border: 1px solid rgba(226, 232, 240, 0.8);
    }

    .spec-item {
        display: flex;
        margin-bottom: 15px;
        padding: 12px;
        border-bottom: 1px dashed #e2e8f0;
        transition: all 0.3s ease;
        align-items: center;
    }

    .spec-item:hover {
        background: linear-gradient(45deg, #f8fafc, #f1f5f9);
        transform: translateX(5px);
        border-radius: 10px;
    }

    .spec-label {
        width: 150px;
        color: #475569;
        font-weight: 600;
        font-size: 0.95rem;
    }

    .spec-value {
        color: #0f172a;
        flex: 1;
        font-weight: 500;
    }

    .buy-buttons {
        display: flex;
        gap: 15px;
        margin: 30px 0;
    }

    .btn-buy-now {
        background: linear-gradient(45deg, #f59e0b, #fbbf24);
        border: none;
        padding: 15px 35px;
        border-radius: 30px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 1px;
        box-shadow: 0 4px 15px rgba(251, 191, 36, 0.3);
    }

    .btn-buy-now:hover {
        background: #f59e0b;
        transform: translateY(-2px);
    }

    .btn-add-cart {
        background: linear-gradient(45deg, #475569, #64748b);
        border: none;
        padding: 15px 35px;
        border-radius: 30px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 1px;
        color: white;
        box-shadow: 0 4px 15px rgba(71, 85, 105, 0.3);
        transition: all 0.3s ease;
    }

    .btn-add-cart:hover {
        background: linear-gradient(45deg, #334155, #475569);
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(71, 85, 105, 0.4);
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
        position: relative;
        overflow: hidden;
        border: none;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        transition: all 0.3s ease;
    }

    .product-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 4px 15px rgba(0,0,0,0.2);
    }

    .card-img-wrapper {
        height: 180px; /* Giảm chiều cao */
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: #ffffff;
        padding: 0.8rem;
    }

    .card-img-top {
        max-height: 100%;
        width: auto;
        object-fit: contain;
        transition: transform 0.3s ease;
    }

    .card-hover-content {
        position: absolute;
        bottom: -100%;
        left: 0;
        right: 0;
        background: rgba(255, 255, 255, 0.95);
        padding: 1rem;
        transition: all 0.3s ease;
        text-align: center;
    }

    .product-card:hover .card-hover-content {
        bottom: 0;
    }

    .card-hover-content .card-title {
        color: #1a202c;
        font-size: 0.9rem;
        font-weight: 600;
        margin-bottom: 0.5rem;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .card-hover-content .card-price {
        color: #dc2626;
        font-weight: 700;
        font-size: 1rem;
        margin-bottom: 0;
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

    /* Skeleton loading styles */
    .skeleton-loading {
        position: relative;
        overflow: hidden;
        background: #e2e8f0;
    }

    .skeleton-loading::after {
        content: "";
        position: absolute;
        top: 0;
        right: 0;
        bottom: 0;
        left: 0;
        transform: translateX(-100%);
        background-image: linear-gradient(
            90deg,
            rgba(255, 255, 255, 0) 0,
            rgba(255, 255, 255, 0.2) 20%,
            rgba(255, 255, 255, 0.5) 60%,
            rgba(255, 255, 255, 0)
        );
        animation: shimmer 2s infinite;
    }

    @keyframes shimmer {
        100% {
            transform: translateX(100%);
        }
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

        .main-image {
            height: 300px;
        }

        .card-img-wrapper {
            height: 160px;
        }

        .card-hover-content {
            bottom: 0;
            background: rgba(255, 255, 255, 0.98);
        }

        .card-hover-content .card-title {
            font-size: 0.8rem;
        }

        .card-hover-content .card-price {
            font-size: 0.9rem;
        }
    }
</style>

<div class="container mt-5">
    <div class="row">
        <!-- Gallery -->
        <div class="col-md-6">
            <div class="product-gallery">
                <div class="main-image-wrapper">
                    <img src="{{ asset($sanpham->hinhsp) }}" class="main-image" id="mainImage" alt="{{ $sanpham->tensp }}">
                </div>

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
                <div class="badges mb-3">
                    @if($sanpham->tgbaohanh_nam >= 2)
                        <span class="badge bg-success">Bảo hành {{ $sanpham->tgbaohanh_nam }} năm</span>
                    @endif
                    <span class="badge bg-info">{{ $sanpham->xuatxu }}</span>
                    <span class="badge bg-primary">{{ $sanpham->khangnuoc }}</span>
                </div>
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
                        <span class="spec-label">Đường kính mặt:</span>
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
                    <form action="{{ route('buy.now', $sanpham->idsp) }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-buy-now">MUA NGAY</button>
                    </form>
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
                        <div class="card-img-wrapper skeleton-loading">
                            <img src="{{ asset($product->hinhsp) }}"
                                 class="card-img-top lazy-load"
                                 data-src="{{ asset($product->hinhsp) }}"
                                 alt="{{ $product->tensp }}">
                        </div>
                        <div class="card-hover-content">
                            <h5 class="card-title">{{ $product->tensp }}</h5>
                            <p class="card-price">{{ number_format($product->gia, 0, ',', '.') }}đ</p>
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
