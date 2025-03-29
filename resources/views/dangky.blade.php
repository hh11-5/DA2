<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang chủ - Web Bán Đồng Hồ</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        /* Header */
        .header {
            background: #343a40;
            color: white;
            padding: 30px 0;
            text-align: center;
        }
        .header h1 {
            font-size: 2.5rem;
        }
        /* Navbar */
        .navbar {
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
        }
        /* Slider */
        .carousel {
            width: 80%;
            margin: 20px auto;
        }
        .carousel-item img {
            max-height: 500px;
            object-fit: cover;
            border-radius: 10px;
        }
        .carousel-caption {
            background: rgba(0, 0, 0, 0.5);
            padding: 10px;
            border-radius: 5px;
        }
        /* Nút điều hướng Slider */
        .carousel-control-prev, .carousel-control-next {
            width: 60px;
            height: 60px;
            background: rgba(0, 0, 0, 0.7);
            border-radius: 50%;
        }
        .carousel-control-prev-icon, .carousel-control-next-icon {
            filter: invert(1);
            width: 30px;
            height: 30px;
        }
        .carousel-control-prev:hover, .carousel-control-next:hover {
            background: rgba(0, 0, 0, 1);
        }
        /* Sidebar */
        .sidebar {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 10px;
        }
        /* Sản phẩm */
        .product-card {
            transition: 0.3s;
        }
        .product-card:hover {
            transform: scale(1.05);
        }
        /* Banner News */
        .news-banner {
            background: url('https://via.placeholder.com/1200x400/007BFF/FFFFFF?text=Tin+Tức+Mới+Nhất') no-repeat center center;
            background-size: cover;
            text-align: center;
            padding: 50px 20px;
            color: white;
            margin-top: 40px;
            border-radius: 10px;
        }
        .news-banner h2 {
            font-size: 2.5rem;
            font-weight: bold;
        }
        .news-banner p {
            font-size: 1.2rem;
            margin-top: 10px;
        }
        /* Footer */
        .footer {
            background: #343a40;
            color: white;
            padding: 20px 0;
            text-align: center;
            margin-top: 40px;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <h1>Chào mừng đến với Web Bán Đồng Hồ</h1>
        <p>Chất lượng - Uy tín - Giá tốt</p>
    </div>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="#">
                <img src="https://via.placeholder.com/40" alt="Logo" class="me-2"> Web Bán Đồng Hồ
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="#">Trang chủ</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Sản phẩm</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Liên hệ</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Slider sản phẩm nổi bật -->
    <div id="highlightCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="4000">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#highlightCarousel" data-bs-slide-to="0" class="active"></button>
            <button type="button" data-bs-target="#highlightCarousel" data-bs-slide-to="1"></button>
            <button type="button" data-bs-target="#highlightCarousel" data-bs-slide-to="2"></button>
        </div>
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="https://via.placeholder.com/1200x500/FF5733/FFFFFF?text=Sản+Phẩm+Nổi+Bật+1" class="d-block w-100" alt="Sản phẩm 1">
                <div class="carousel-caption d-none d-md-block">
                    <h3>Đồng Hồ Cao Cấp</h3>
                    <p>Thiết kế tinh tế, sang trọng.</p>
                </div>
            </div>
            <div class="carousel-item">
                <img src="https://via.placeholder.com/1200x500/3498DB/FFFFFF?text=Sản+Phẩm+Nổi+Bật+2" class="d-block w-100" alt="Sản phẩm 2">
                <div class="carousel-caption d-none d-md-block">
                    <h3>Đồng Hồ Thể Thao</h3>
                    <p>Phong cách mạnh mẽ, nam tính.</p>
                </div>
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#highlightCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#highlightCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
        </button>
    </div>

    <div class="container mt-4">
        <h2 class="text-center mb-4">Danh sách sản phẩm</h2>
        <div class="row">
            @for ($i = 0; $i < 6; $i++)
                <div class="col-md-4 mb-4">
                    <div class="card product-card">
                        <img src="https://via.placeholder.com/150?text=?" class="card-img-top" alt="Sản phẩm">
                        <div class="card-body">
                            <h5 class="card-title">Sản phẩm ?</h5>
                            <p class="card-text">Giá: ? VNĐ</p>
                            <a href="#" class="btn btn-primary">Xem chi tiết</a>
                        </div>
                    </div>
                </div>
            @endfor
        </div>
    </div>

    <!-- Banner News -->
    <div class="news-banner">
        <h2>Tin tức mới nhất về đồng hồ</h2>
        <p>Cập nhật xu hướng, công nghệ và đánh giá sản phẩm.</p>
        <a href="#" class="btn btn-light mt-3">Xem tin tức</a>
    </div>

    <!-- Footer -->
    <div class="footer">
        <p>&copy; 2025 Web Bán Đồng Hồ. Tất cả các quyền được bảo lưu.</p>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
