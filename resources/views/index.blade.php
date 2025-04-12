@extends('layouts.app')

@section('content')
    <style>
        /* ===== CSS CHO BANNER MỚI ===== */
        .banner-section {
            margin-top: 20px;
            margin-bottom: 40px;
        }

        .banner-slide {
            height: 360px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #94a3b8, #475569); /* Xám xanh */
            color: #fff;
            flex-direction: column;
            padding: 30px;
            border-radius: 20px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }

        .banner-slide h2 {
            font-size: 2.5rem;
            font-weight: bold;
            margin-bottom: 15px;
        }

        .banner-slide p {
            font-size: 1.2rem;
        }

        .carousel-control-prev-icon,
        .carousel-control-next-icon {
            background-color: rgba(255, 255, 255, 0.7);
            border-radius: 50%;
            padding: 10px;
        }

        .carousel-item img {
            transition: transform 0.3s ease-in-out;
            object-fit: cover;
            max-height: 450px;
        }

        .carousel-item img:hover {
            transform: scale(1.02);
        }

        .card-img-top {
            object-fit: cover;
            height: 200px;
        }

        .card-title {
            font-weight: 600;
        }

        .section-spacing {
            margin-top: 40px;
            margin-bottom: 40px;
        }

        .card {
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        .card:hover {
            transform: translateY(5px); /* Hiệu ứng chìm xuống */
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.25); /* Đổ bóng đẹp mắt */
        }

        /* Phần nền gradient cho tin tức */
        .news-section {
            background: linear-gradient(180deg, #f0f4f8 0%, #d9e2ec 100%);
            border-radius: 16px;
            padding: 30px;
        }

        /* Navbar cố định */okp
.navbar {
    position: fixed;
    top: 0;
    width: 100%;
    background-color: #fff;
    z-index: 1000;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

/* Giữ nội dung không bị che */
body {
    padding-top: 80px;
}
    </style>

    <div class="container mt-4">
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

        <!-- Sản phẩm nổi bật -->
        <div class="section-spacing">
            <h5 class="mb-4">Sản phẩm nổi bật</h5>
            <div id="productCarousel" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <div class="d-flex justify-content-center">
                            <div class="card" style="width: 18rem;">
                                <img src="#" class="card-img-top" alt="Sản phẩm 1">
                                <div class="card-body">
                                    <h5 class="card-title">Đồng hồ nam cao cấp</h5>
                                    <p class="card-text text-muted">Giá: 3.500.000đ</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Thêm sản phẩm khác nếu cần -->
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#productCarousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon p-2" aria-hidden="true"></span>
                    <span class="visually-hidden">Trước</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#productCarousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon p-2" aria-hidden="true"></span>
                    <span class="visually-hidden">Sau</span>
                </button>
            </div>
        </div>

        <!-- Tin tức -->
        <div class="section-spacing news-section">
            <h5 class="mb-4">Tin tức</h5>
            <div class="row">
                <div class="col-md-4 mb-3">
                    <div class="card h-100">
                        <img src="#" class="card-img-top" alt="Tin tức 1">
                        <div class="card-body">
                            <h6 class="card-title">Top đồng hồ hot 2025</h6>
                            <p class="card-text text-muted">Khám phá những mẫu đồng hồ đang được ưa chuộng nhất hiện nay.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="card h-100">
                        <img src="#" class="card-img-top" alt="Tin tức 2">
                        <div class="card-body">
                            <h6 class="card-title">Đồng hồ cho doanh nhân</h6>
                            <p class="card-text text-muted">Gợi ý mẫu đồng hồ đẳng cấp phù hợp khi đi họp, gặp đối tác.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="card h-100">
                        <img src="#" class="card-img-top" alt="Tin tức 3">
                        <div class="card-body">
                            <h6 class="card-title">Mẹo bảo quản đồng hồ</h6>
                            <p class="card-text text-muted">Những điều cần biết để giữ đồng hồ luôn như mới.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
