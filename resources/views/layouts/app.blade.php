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
        }

        .top-navbar {
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            padding: 10px 0;
        }

        .bottom-navbar {
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            padding: 8px 0;
            margin-top: 70px !important; /* Giảm margin */
        }

        body {
            padding-top: 120px; /* Giảm padding-top */
        }

        .navbar-brand img {
            height: 50px; /* Giảm kích thước logo */
        }

        /* Làm gọn dropdown menu */
        .dropdown-menu {
            border: none;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            border-radius: 8px;
            padding: 0.5rem;
        }

        .dropdown-item {
            padding: 0.5rem 1rem;
            border-radius: 4px;
        }

        .dropdown-item:hover {
            background-color: #f8f9fa;
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

    /* Thống nhất style giá sản phẩm */
    .product-price, 
    .card-text.price {
        color: #dc2626 !important; /* Màu đỏ giống detail */
        font-weight: bold;
        font-size: 1.1rem;
    }

    /* Card styles */
    .card {
        border: none;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        transition: all 0.3s ease;
    }

    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 4px 15px rgba(0,0,0,0.2);
    }

    .card-img-top {
        padding: 1rem;
        object-fit: contain;
        height: 200px;
    }
    /* Style chung cho giá sản phẩm */
    .card-text.text-muted,
    .card-text.price,
    .product-price {
        color: #dc2626 !important;
        font-weight: bold;
        font-size: 1.1rem;
    }

    /* Thêm vào phần style của file */
    .dropdown-submenu {
        position: absolute;
        left: 100%;
        top: 0;
        display: none;
    }

    .dropdown-item.dropdown-toggle {
        position: relative;
    }

    .dropdown-item.dropdown-toggle::after {
        position: absolute;
        right: 10px;
        top: 50%;
        transform: translateY(-50%);
    }

    .dropdown-item:hover > .dropdown-submenu {
        display: block;
    }

    /* Thay đổi style cho form tìm kiếm */
    .search-form {
        min-width: 400px; /* Tăng độ rộng tối thiểu */
        max-width: 600px; /* Giới hạn độ rộng tối đa */
        width: 100%;
        margin: 0 auto;
    }

    .search-form .form-control {
        width: 100%;
        padding: 0.6rem 1rem;
        border-radius: 20px;
        border: 1px solid #e2e8f0;
        transition: all 0.3s ease;
    }

    .search-form .form-control:focus {
        border-color: #fbbf24;
        box-shadow: 0 0 0 2px rgba(251, 191, 36, 0.2);
    }

    /* Responsive */
    @media (max-width: 992px) {
        .search-form {
            min-width: 300px;
        }
    }

    @media (max-width: 768px) {
        .search-form {
            min-width: 100%;
        }
    }
    </style>
</head>
<body>
    <!-- Header -->
    <header>
        <nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom fixed-top">
            <div class="container">
                <!-- Logo -->
                <a href="/" class="navbar-brand">
                    <img src="{{ asset('images/WebDH2.png') }}" alt="Watch Store Logo" height="60">
                </a>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="mainNav">
                    <!-- Menu chính -->
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#"
                               role="button"
                               data-bs-toggle="dropdown"
                               aria-expanded="false">
                                Thương hiệu
                            </a>
                            <ul class="dropdown-menu">
                                @foreach(App\Models\NhaSanXuat::all() as $nhasx)
                                <li><a class="dropdown-item" href="{{ route('brands.page', $nhasx->idnhasx) }}">
                                    {{ $nhasx->tennhasx }}</a></li>
                                @endforeach
                            </ul>
                        </li>
                        
<!-- Thay thế phần dropdown Giới tính hiện tại -->
<li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
        Giới tính
    </a>
    <ul class="dropdown-menu">
        <li>
            <a class="dropdown-item" href="{{ route('products.by.type', ['type' => 'Đồng hồ nam']) }}">Nam</a>
        </li>
        <li>
            <a class="dropdown-item" href="{{ route('products.by.type', ['type' => 'Đồng hồ nữ']) }}">Nữ</a>
        </li>
    </ul>
</li>

                     
                    </ul>

                    <!-- Thanh tìm kiếm -->
                    <form action="{{ route('search') }}" method="GET" class="search-form d-flex mx-3">
                        <input class="form-control me-2" type="search" name="query"
                               value="{{ request('query') }}"
                               placeholder="Tìm kiếm theo tên...">
                        <button type="submit" class="btn btn-outline-dark">
                            <i class="fas fa-search"></i>
                        </button>
                    </form>

                    <!-- Giỏ hàng và tài khoản -->
                    <div class="nav-item d-flex align-items-center">
                        @auth
                            @if(!Auth::user()->nhanVien)
                                <a href="{{ route('cart.index') }}" class="btn btn-outline-dark position-relative me-2">
                                    <i class="fas fa-shopping-cart"></i>
                                    @if(isset($cartInfo) && $cartInfo['count'] > 0)
                                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                            {{ $cartInfo['count'] }}
                                        </span>
                                    @endif
                                </a>
                            @endif
                            <div class="dropdown">
                                <button class="btn btn-outline-dark dropdown-toggle"
                                        type="button"
                                        data-bs-toggle="dropdown"
                                        aria-expanded="false">
                                    @if(Auth::user()->nhanVien)
                                        {{ Auth::user()->nhanVien->honv }} {{ Auth::user()->nhanVien->tennv }}
                                    @elseif(Auth::user()->khachHang)
                                        {{ Auth::user()->khachHang->hokh }} {{ Auth::user()->khachHang->tenkh }}
                                    @else
                                        {{ Auth::user()->emailtk }}
                                    @endif
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    @if(!Auth::user()->nhanVien)
                                        <li>
                                            <a class="dropdown-item" href="{{ route('profile') }}">
                                                <i class="fas fa-user me-2"></i>Thông tin tài khoản
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="{{ route('orders.history') }}">
                                                <i class="fas fa-history me-2"></i>Lịch sử đơn hàng
                                            </a>
                                        </li>
                                    @endif
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <form action="{{ route('auth.logout') }}" method="POST">
                                            @csrf
                                            <button type="submit" class="dropdown-item">
                                                <i class="fas fa-sign-out-alt me-2"></i>Đăng xuất
                                            </button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        @else
                            <a href="{{ route('auth') }}" class="btn btn-outline-dark">
                                <i class="fas fa-user me-1"></i>Đăng nhập / Đăng ký
                            </a>
                        @endauth
                    </div>
                </div>
            </div>
        </nav>
    </header>

    <style>
        .navbar {
            padding: 1rem 0;
            background-color: #fff;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }

        body {
            padding-top: 76px;
        }

        .navbar-brand img {
            height: 60px;
            transition: height 0.3s ease;
        }

        .nav-link {
            padding: 0.5rem 1rem !important;
            font-weight: 500;
        }

        .dropdown-menu {
            margin-top: 0.5rem;
            border: none;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            border-radius: 8px;
        }

        @media (max-width: 992px) {
            .navbar-brand img {
                height: 50px;
            }

            .nav-item.d-flex {
                margin-top: 1rem;
                justify-content: center;
            }
        }
    </style>

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
                        <i class="fas fa-shopping-cart me-1"></i>
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
                        <i class="fas fa-shopping-cart me-1"></i>
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

document.querySelector('.search-btn').addEventListener('click', function(e) {
    e.preventDefault();
    const searchForm = this.closest('form');
    const searchInput = searchForm.querySelector('input[name="query"]');

    if (searchInput.value.trim()) {
        // Nếu có từ khóa tìm kiếm -> submit form tìm kiếm
        searchForm.submit();
    } else {
        // Nếu không có từ khóa -> chuyển đến trang hiển thị tất cả sản phẩm
        window.location.href = '{{ route("products.index") }}';
    }
});

// Thêm vào phần script của file
document.addEventListener('DOMContentLoaded', function() {
    const dropdownItems = document.querySelectorAll('.dropdown-item.dropdown-toggle');
    
    dropdownItems.forEach(item => {
        item.addEventListener('mouseover', function() {
            const submenu = this.nextElementSibling;
            if (submenu) {
                submenu.style.display = 'block';
            }
        });
        
        item.parentElement.addEventListener('mouseleave', function() {
            const submenu = this.querySelector('.dropdown-submenu');
            if (submenu) {
                submenu.style.display = 'none';
            }
        });
    });
});
</script>
</body>
</html>
