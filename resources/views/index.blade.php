@include('header')
@include('navbar')
@include('cart')

<!-- BANNER GIỚI THIỆU -->
<div id="bannerCarousel" class="carousel slide banner-section" data-bs-ride="carousel">
    <div class="carousel-inner">
        <div class="carousel-item active">
            <div class="banner-slide text-center">
                <h2>Mẫu đồng hồ mới nhất 2025</h2>
                <p>Thiết kế tinh tế - Sang trọng - Đẳng cấp</p>
            </div>
        </div>
        <div class="carousel-item">
            <div class="banner-slide text-center">
                <h2>Đồng hồ thể thao hiện đại</h2>
                <p>Bền bỉ - Chính xác - Thời thượng</p>
            </div>
        </div>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#bannerCarousel" data-bs-slide="prev">
        <span class="carousel-control-prev-icon"></span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#bannerCarousel" data-bs-slide="next">
        <span class="carousel-control-next-icon"></span>
    </button>
</div>

<!-- SẢN PHẨM BÁN CHẠY -->
<div class="container mt-5">
    <h3 class="section-title text-center">Sản phẩm bán chạy</h3>
    <div id="bestSellerCarousel" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner text-center">
            @for ($i = 0; $i < 4; $i++)
                <div class="carousel-item {{ $i === 0 ? 'active' : '' }}">
                    <div class="card product-card mx-auto">
                        <img src="https://via.placeholder.com/300x300?text=Sản+phẩm+{{ $i+1 }}" class="card-img-top" alt="Sản phẩm {{ $i+1 }}">
                        <div class="card-body">
                            <h5 class="card-title">Sản phẩm {{ $i+1 }}</h5>
                            <p class="card-text">Giá: {{ number_format(1000000 + $i * 500000) }} VNĐ</p>
                        </div>
                    </div>
                </div>
            @endfor
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#bestSellerCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon"></span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#bestSellerCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon"></span>
        </button>
    </div>
</div>

<!-- TIN TỨC -->
<div class="container mt-5">
    <h3 class="section-title text-center">Tin tức</h3>
    <div class="row">
        @for ($i = 1; $i <= 4; $i++)
            <div class="col-md-3 mb-4">
                <div class="card news-card">
                    <img src="https://via.placeholder.com/300x200?text=Tin+{{ $i }}" class="card-img-top" alt="Tin {{ $i }}">
                    <div class="card-body">
                        <h5 class="card-title">Bài viết {{ $i }}</h5>
                        <p class="card-text">Tóm tắt bài viết {{ $i }}...</p>
                    </div>
                </div>
            </div>
        @endfor
    </div>
</div>

@include('footer')

<!-- Thêm CSS vào đây -->
<style>
    body {
        font-family: 'Segoe UI', sans-serif;
    }

    /* Banner */
    .banner-section {
        margin-top: 20px;
    }
    .banner-slide {
        background: linear-gradient(to right, #007bff, #6c757d);
        color: white;
        padding: 80px 20px;
        border-radius: 12px;
    }

    /* Sản phẩm bán chạy */
    .product-card {
        width: 300px;
        margin: 0 15px;
        transition: transform 0.3s ease;
    }
    .product-card img {
        border-radius: 8px;
    }
    .product-card:hover {
        transform: scale(1.05);
    }

    /* Tin tức */
    .news-card {
        transition: 0.3s;
    }
    .news-card:hover {
        transform: scale(1.03);
    }
    .news-card img {
        border-radius: 8px 8px 0 0;
    }

    /* Footer */
    .footer {
        background-color: #343a40;
    }

    /* Navbar */
    .navbar {
        background-color: #007bff;
    }

    .navbar-nav .nav-link {
        font-size: 16px;
        padding-left: 20px;
        padding-right: 20px;
    }
</style>
