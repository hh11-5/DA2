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
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            height: 100%;
            max-width: 300px;
            margin: 0 auto;
            border: none;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 20px rgba(0, 0, 0, 0.15);
        }

        .card-img-top {
            height: 220px;
            object-fit: contain;
            padding: 1rem;
            background-color: #ffffff;
            transition: transform 0.3s ease;
        }

        .card:hover .card-img-top {
            transform: scale(1.05);
        }

        .card-body {
            padding: 1.25rem;
            background: linear-gradient(to bottom, #ffffff, #f8f9fa);
        }

        .card-title {
            font-size: 1.1rem;
            font-weight: 600;
            margin-bottom: 0.75rem;
            color: #2d3748;
        }

        .card-text {
            font-size: 1rem;
            color: #4a5568;
        }

        /* Thêm hiệu ứng hover cho giá */
        .card:hover .card-text {
            color: #2b6cb0;
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
            padding-top: 150px;
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

        .card {
            transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            cursor: pointer;
        }

        .text-decoration-none:hover {
            text-decoration: none;
        }

        .text-decoration-none:hover .card-title {
            color: #0d6efd;
        }

        /* CSS cho thẻ thương hiệu */
        .brand-card {
            background: white;
            border-radius: 12px;
            padding: 2rem;
            text-align: center;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .brand-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 16px rgba(0,0,0,0.15);
            background-color: #f8f9fa;
        }

        .brand-name {
            color: #2d3748;
            font-weight: 600;
            margin: 0;
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

        <!-- Sản phẩm mới nhất -->
        <div class="section-spacing">
            <h5 class="mb-4">Sản phẩm mới nhất</h5>
            <div class="row row-cols-2 row-cols-md-3 g-3">
                @foreach($sanphams as $sanpham)
                <div class="col">
                    <a href="{{ route('products.show', $sanpham->idsp) }}" class="text-decoration-none">
                        <div class="card h-100">
                            @if($sanpham->hinhsp)
                                <img src="{{ asset($sanpham->hinhsp) }}" class="card-img-top" alt="{{ $sanpham->tensp }}">
                            @else
                                <img src="{{ asset('images/placeholder.png') }}" class="card-img-top" alt="Placeholder">
                            @endif
                            <div class="card-body">
                                <h5 class="card-title text-dark">{{ $sanpham->tensp }}</h5>
                                <p class="card-text text-muted">Giá: {{ number_format($sanpham->gia, 0, ',', '.') }}đ</p>
                            </div>
                        </div>
                    </a>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Sau phần sản phẩm mới nhất -->
        <div class="section-spacing">
            <h5 class="mb-4">Thương hiệu đồng hồ</h5>
            <div class="row row-cols-2 row-cols-md-3 g-4 mb-4">
                @foreach($thuonghieus as $th)
                <div class="col">
                    <div class="brand-card" data-brand-id="{{ $th->idnhasx }}">
                        <div class="brand-content">
                            <h5 class="brand-name">{{ $th->tennhasx }}</h5>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Thêm container để hiển thị sản phẩm theo thương hiệu -->
            <div id="brand-products" class="mt-4" style="display: none;">
                <h5 id="brand-title" class="mb-4"></h5>
                <div class="row row-cols-2 row-cols-md-3 g-3" id="brand-products-container">
                </div>
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

@section('scripts')
<script>
document.querySelectorAll('.brand-card').forEach(card => {
    card.addEventListener('click', function() {
        const brandId = this.dataset.brandId;
        const brandName = this.querySelector('.brand-name').textContent;

        // Lấy container hiển thị sản phẩm theo thương hiệu
        const brandProductsSection = document.getElementById('brand-products');
        const brandTitle = document.getElementById('brand-title');
        const productsContainer = document.getElementById('brand-products-container');

        fetch(`/brands/${brandId}`)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(products => {
                // Cập nhật tiêu đề
                brandTitle.textContent = `Sản phẩm ${brandName}`;

                if (products.length === 0) {
                    productsContainer.innerHTML = `
                        <div class="col-12">
                            <div class="alert alert-info">
                                Hiện chưa có sản phẩm nào của thương hiệu ${brandName}
                            </div>
                        </div>
                    `;
                } else {
                    productsContainer.innerHTML = products.map(product => `
                        <div class="col">
                            <a href="/products/${product.idsp}" class="text-decoration-none">
                                <div class="card h-100">
                                    <img src="${product.hinhsp || '/images/placeholder.png'}" class="card-img-top" alt="${product.tensp}">
                                    <div class="card-body">
                                        <h5 class="card-title text-dark">${product.tensp}</h5>
                                        <p class="card-text text-muted">Giá: ${new Intl.NumberFormat('vi-VN').format(product.gia)}đ</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                    `).join('');
                }

                // Hiển thị phần sản phẩm
                brandProductsSection.style.display = 'block';

                // Scroll đến phần sản phẩm của thương hiệu
                brandProductsSection.scrollIntoView({ behavior: 'smooth' });
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Có lỗi xảy ra khi tải sản phẩm');
            });
    });
});
</script>
@endsection
