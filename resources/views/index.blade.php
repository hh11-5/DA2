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
            background-color: #f8f9fa;
        }

        /* Thêm icon ? cho placeholder */ ok
        .card-img-top[src*="placeholder"] {
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 48px;
            color: #dee2e6;
            background-color: #f8f9fa;
        }

        .card-img-top[src*="placeholder"]::after {
            content: "?";
        }

        .card-title {
            font-weight: 600;
        }

        .section-spacing {
            margin-top: 40px;
            margin-bottom: 40px;
            position: relative;
            padding: 0 25px; /* Thêm padding để tránh nút bị cắt */
        }

        .card {
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            margin-bottom: 20px;
            height: 100%;
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

        /* Navbar cố định */
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

        /* CSS cho nút điều hướng sản phẩm */
        #productCarousel .carousel-nav {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            width: 40px;
            height: 40px;
            border: none;
            border-radius: 50%;
            background-color: white;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            color: #333;
            transition: all 0.3s ease;
            z-index: 10;
        }

        #productCarousel .carousel-nav:hover {
            background-color: #f8f9fa;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            transform: translateY(-50%) scale(1.1);
        }

        #productCarousel .carousel-nav-prev {
            left: -50px;
        }

        #productCarousel .carousel-nav-next {
            right: -50px;
        }

        /* Ẩn outline khi focus */
        #productCarousel .carousel-nav:focus {
            outline: none;
            box-shadow: 0 0 0 3px rgba(13, 110, 253, 0.25);
        }

        /* Điều chỉnh kích thước icon */  ok
        #productCarousel .carousel-nav i {
            font-size: 16px;
        }

        /* CSS cho layout 3 sản phẩm */
        .carousel-inner .row {
            margin: 0 -15px;
        }

        .carousel-inner .col-md-4 {
            padding: 0 15px;
        }

        .card {
            margin-bottom: 20px;
            height: 100%;
        }

        /* CSS cho nút điều hướng sản phẩm */
        #newProductCarousel .carousel-nav {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            width: 40px;
            height: 40px;
            border: none;
            border-radius: 50%;
            background-color: rgba(255, 255, 255, 0.9);
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            color: #333;
            transition: all 0.3s ease;
            z-index: 10;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        #newProductCarousel .carousel-nav:hover {
            background-color: #fff;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            transform: translateY(-50%) scale(1.1);
        }

        #newProductCarousel .carousel-nav-prev {
            left: -20px; /* Thay đổi từ -50px thành -20px */
        }

        #newProductCarousel .carousel-nav-next {
            right: -20px; /* Thay đổi từ -50px thành -20px */
        }

        /* Điều chỉnh responsive */
        @media (max-width: 768px) {
            .carousel-inner .col-md-4 {
                margin-bottom: 20px;
            }

            #productCarousel .carousel-nav-prev {
                left: -20px;
            }

            #productCarousel .carousel-nav-next {
                right: -20px;
            }
        }

        /* CSS cho card sản phẩm */
        .card {
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            margin-bottom: 20px;
            height: 100%;
            max-width: 280px; /* Giảm kích thước tối đa */
            margin: 0 auto; /* Căn giữa card */
        }

        .card:hover {
            transform: translateY(5px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.25);
        }

        .card-img-top {
            height: 180px; /* Giảm chiều cao hình */
            object-fit: cover;
            background-color: #f8f9fa;
        }

        .card-title {
            font-weight: 600;
        }

        .card-body {
            padding: 1rem; /* Giảm padding */
        }

        .card-title {
            font-size: 1rem; /* Giảm kích thước chữ */
            margin-bottom: 0.5rem;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .col {
                margin-bottom: 20px;
            }
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



        <!-- Sản phẩm -->
        <div class="section-spacing">
            <h5 class="mb-4">Sản phẩm</h5>
            <div class="row row-cols-2 row-cols-md-3 g-3"> <!-- Thay đổi spacing -->
                @foreach($sanphams as $sanpham)
                <div class="col">
                    <div class="card h-100">
                        <img src="{{ asset('images/placeholder.png') }}" class="card-img-top" alt="Placeholder">
                        <div class="card-body">
                            <h5 class="card-title">{{ $sanpham->tensp }}</h5>
                            <p class="card-text text-muted">Giá: {{ number_format($sanpham->gia, 0, ',', '.') }}đ</p>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Tin tức -->
        <div class="section-spacing news-section">
            <h5 class="mb-4">Tin tức</h5>
            <div class="row">
                @foreach($tintuc as $item)
                <div class="col-md-4 mb-3">
                    <a href="{{ $item['link'] }}" target="_blank" class="text-decoration-none">
                        <div class="card h-100">
                            <img src="{{ $item['hinhanh'] }}" class="card-img-top" alt="{{ $item['tieude'] }}">
                            <div class="card-body">
                                <h6 class="card-title">{{ $item['tieude'] }}</h6>
                                <p class="card-text text-muted">{{ $item['tomtat'] }}</p>
                            </div>
                        </div>
                    </a>
                </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
