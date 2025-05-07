<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Watch Store</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* Navbar styles */
        .navbar {
            position: fixed;
            top: 0;
            width: 100%;
            background-color: #fff;
            z-index: 1000;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        /* Điều chỉnh padding-top cho body */
        body {
            padding-top: 140px; /* Giảm xuống từ 160px */
        }

        .navbar-brand {
            padding: 0;
            margin-right: 2rem;
        }

        .navbar-brand img {
            height: 60px; /* Giảm kích thước logo một chút */
        }

        /* Căn giữa form tìm kiếm */
        .search-form {
            width: 100%;
            max-width: 500px;
            margin: 0 auto;
        }

        /* Điều chỉnh bottom navbar */
        .bottom-navbar {
            margin-top: 100px !important; /* Giảm khoảng cách giữa 2 navbar */
            z-index: 1 !important;
        }

        /* Responsive */
        @media (max-width: 768px) {
            body {
                padding-top: 100px;
            }
        }

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

        footer.footer {
        background: linear-gradient(135deg, #94a3b8, #475569); /* Xám xanh */
        box-shadow: 0 -6px 16px rgba(0, 0, 0, 0.2);
        color: #fff;
        border-top-left-radius: 20px;
        border-top-right-radius: 20px;
    }

    footer.footer a {
        color: #e2e8f0;
    }

    footer.footer a:hover {
        text-decoration: underline;
        color: #facc15;
    }

    footer.footer h5 {
        color: #f1f5f9;
        font-weight: bold;
        margin-bottom: 15px;
    }

    .btn-outline-dark:hover .badge {
        transform: scale(1.1);
        transition: transform 0.2s ease;
    }

    .btn-outline-dark {
        display: inline-flex;
        align-items: center;
        padding: 0.5rem 1rem;
        font-weight: 500;
        border-width: 2px;
    }

    .btn-outline-dark:hover {
        background-color: #f8f9fa;
        color: #212529;
        border-color: #212529;
    }

    .badge {
        transition: all 0.3s ease;
    }

    .text-success {
        animation: fadeIn 0.5s ease;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    </style>
</head>
<body>
    <!-- Header -->
    <header>
        <!-- Top navbar with logo and search -->
        <nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom fixed-top">
            <div class="container">
                <a href="/" class="navbar-brand">
                    <img src="{{ asset('images/WebDH2.png') }}" alt="Watch Store Logo" height="70">
                </a>

                <div class="col-md-6">
                    <form action="{{ route('search') }}" method="GET" class="d-flex position-relative">
                        <input
                            class="form-control me-2"
                            type="search"
                            name="query"
                            value="{{ request('query') }}"
                            placeholder="Tìm kiếm theo tên, giá hoặc thương hiệu..."
                            required>
                        <button class="btn btn-outline-dark" type="submit">
                            <i class="fas fa-search"></i>
                        </button>
                    </form>
                </div>

                <div class="col-md-3 text-end">
                    @auth
                        <div class="dropdown">
                            <button class="btn btn-outline-dark dropdown-toggle" type="button" id="userDropdown" data-bs-toggle="dropdown">
                                Xin chào, {{ Auth::user()->khachHang->tenkh }}
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="{{ route('profile') }}">
                                    <i class="fas fa-user me-2"></i>Thông tin tài khoản
                                </a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form action="{{ route('auth.logout') }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="dropdown-item">Đăng xuất</button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                        @if(!Auth::user()->nhanVien)
                            <a href="{{ route('cart.index') }}" class="btn btn-outline-dark position-relative ms-2">
                                <i class="fas fa-shopping-cart me-1"></i>Giỏ hàng
                                @if(isset($cart) && count($cart) > 0)
                                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger"
                                          style="font-size: 0.8rem; padding: 0.4em 0.6em;">
                                        {{ count($cart) }}
                                    </span>
                                    <span class="ms-3 text-success" style="font-weight: 600;">
                                        {{ number_format($total, 0, ',', '.') }}đ
                                    </span>
                                @else
                                    <span class="ms-2 text-muted">(Trống)</span>
                                @endif
                            </a>
                        @endif
                    @else
                        <a href="{{ route('auth') }}" class="btn btn-outline-dark">Đăng nhập / Đăng ký</a>
                    @endauth
                </div>
            </div>
        </nav>

        <!-- Bottom navbar with categories -->
        <nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom bottom-navbar" style="margin-top: 80px;">
            <div class="container">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button">Thương hiệu</a>
                            <ul class="dropdown-menu">
                                @foreach(App\Models\NhaSanXuat::all() as $nhasx)
                                <li>
                                    <a class="dropdown-item" href="{{ route('brands.page', $nhasx->idnhasx) }}">
                                        {{ $nhasx->tennhasx }}
                                    </a>
                                </li>
                                @endforeach
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
                    <ul class="navbar-nav ms-auto">
                        <!-- Không cần code cart ở đây nữa -->
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <!-- Main Content -->
    <main class="py-4">
        <div class="container mt-3">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
        </div>
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
                    <li><a href="#" class="text-dark text-decoration-none">Chính sách vận chuyển</a></li>
                        <li><a href="#" class="text-dark text-decoration-none">Chính sách hoàn tiền</a></li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <h5>Về chúng tôi</h5>
                    <ul class="list-unstyled">
                        <li><a href="#" class="text-dark text-decoration-none">Giới thiệu</a></li>
                        <li><a href="#" class="text-dark text-decoration-none">Tuyển dụng</a></li>
                        <li><a href="#" class="text-dark text-decoration-none">Liên hệ</a></li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <h5>Follow chúng tôi</h5>
                    <ul class="list-inline">
                        <li class="list-inline-item"><a href="#"><i class="fab fa-facebook fa-lg"></i></a></li>
                        <li class="list-inline-item"><a href="#"><i class="fab fa-instagram fa-lg"></i></a></li>
                        <li class="list-inline-item"><a href="#"><i class="fab fa-twitter fa-lg"></i></a></li>
                        <li class="list-inline-item"><a href="#"><i class="fab fa-youtube fa-lg"></i></a></li>
                    </ul>
                </div>
            </div>
            <div class="text-center mt-4">
                <p class="mb-0">&copy; 2025 Watch Store. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    @yield('scripts')
    <!-- Thêm script này trước thẻ </body> -->
<script>
function updateCartInfo() {
    fetch('/cart/info')
        .then(response => response.json())
        .then(data => {
            const cartButton = document.querySelector('a[href="{{ route('cart.index') }}"]');
            if (cartButton) {
                if (data.count > 0) {
                    cartButton.innerHTML = `
                        <i class="fas fa-shopping-cart me-1"></i>Giỏ hàng
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger"
                              style="font-size: 0.8rem; padding: 0.4em 0.6em;">
                            ${data.count}
                        </span>
                        <span class="ms-3 text-success" style="font-weight: 600;">
                            ${new Intl.NumberFormat('vi-VN').format(data.total)}đ
                        </span>
                    `;
                } else {
                    cartButton.innerHTML = `
                        <i class="fas fa-shopping-cart me-1"></i>Giỏ hàng
                        <span class="ms-2 text-muted">(Trống)</span>
                    `;
                }
            }
        })
        .catch(error => console.error('Error:', error));
}

// Cập nhật giỏ hàng khi trang load
document.addEventListener('DOMContentLoaded', updateCartInfo);

// Cập nhật giỏ hàng sau khi thêm sản phẩm thành công
if (document.querySelector('.alert-success')) {
    updateCartInfo();
}

// Thêm event listener cho nút thêm vào giỏ
document.querySelectorAll('form[action*="cart/add"]').forEach(form => {
    form.addEventListener('submit', function() {
        setTimeout(updateCartInfo, 500);
    });
});
</script>
</body>
</html>
