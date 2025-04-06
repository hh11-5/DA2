<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Watch Store</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .dropdown:hover .dropdown-menu {
            display: block;
        }
        .navbar {
            padding: 15px 0;
        }
        .footer {
            background-color: #f8f9fa;
            padding: 40px 0;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header class="bg-light">
        <div class="container py-3">
            <div class="row align-items-center">
                <div class="col-md-3">
                    <a href="/" class="navbar-brand">
                        <img src="/images/logo.png" alt="Watch Store Logo" height="50">
                    </a>
                </div>
                <div class="col-md-6">
                    <form class="d-flex">
                        <input class="form-control me-2" type="search" placeholder="Tìm kiếm đồng hồ...">
                        <button class="btn btn-outline-dark" type="submit">
                            <i class="fas fa-search"></i>
                        </button>
                    </form>
                </div>
                <div class="col-md-3 text-end">
                    <a href="/login" class="btn btn-outline-dark me-2">Đăng nhập / Đăng ký</a>
                    <a href="/cart" class="btn btn-dark">
                        <i class="fas fa-shopping-cart"></i>
                        <span class="badge bg-danger">0</span>
                    </a>
                </div>
            </div>
        </div>
    </header>

    <!-- Navigation Menu -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom">
        <div class="container">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button">Thương hiệu</a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#">Rolex</a></li>
                            <li><a class="dropdown-item" href="#">Omega</a></li>
                            <li><a class="dropdown-item" href="#">Seiko</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button">Nam</a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#">Dưới 5 triệu</a></li>
                            <li><a class="dropdown-item" href="#">5-10 triệu</a></li>
                            <li><a class="dropdown-item" href="#">Trên 10 triệu</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button">Nữ</a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#">Dưới 3 triệu</a></li>
                            <li><a class="dropdown-item" href="#">3-7 triệu</a></li>
                            <li><a class="dropdown-item" href="#">Trên 7 triệu</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button">Cặp đôi</a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#">Đồng hồ cơ</a></li>
                            <li><a class="dropdown-item" href="#">Đồng hồ điện tử</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/contact">Liên hệ</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="py-4">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-12">
                    @yield('content')
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <h5>Chính sách</h5>
                    <ul class="list-unstyled">
                        <li><a href="#" class="text-dark text-decoration-none">Chính sách bảo hành</a></li>
                        <li><a href="#" class="text-dark text-decoration-none">Chính sách đổi trả</a></li>
                        <li><a href="#" class="text-dark text-decoration-none">Chính sách vận chuyển</a></li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <h5>Thông tin</h5>
                    <ul class="list-unstyled">
                        <li><a href="#" class="text-dark text-decoration-none">Về chúng tôi</a></li>
                        <li><a href="#" class="text-dark text-decoration-none">Cửa hàng</a></li>
                        <li><a href="#" class="text-dark text-decoration-none">Liên hệ</a></li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <h5>Điều khoản</h5>
                    <ul class="list-unstyled">
                        <li><a href="#" class="text-dark text-decoration-none">Điều khoản sử dụng</a></li>
                        <li><a href="#" class="text-dark text-decoration-none">Chính sách bảo mật</a></li>
                        <li><a href="#" class="text-dark text-decoration-none">FAQ</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
