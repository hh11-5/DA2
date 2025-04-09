<!-- Topbar: Tìm kiếm + giỏ hàng -->
<div class="topbar bg-light py-2 px-4 d-flex justify-content-between align-items-center">
    <form class="d-flex" style="width: 70%;">
        <input class="form-control me-2" type="search" placeholder="Tìm kiếm sản phẩm..." aria-label="Search">
        <button class="btn btn-outline-primary" type="submit">Tìm</button>
    </form>
    <div class="cart-icon">
        <a href="#"><img src="https://cdn-icons-png.flaticon.com/512/3144/3144456.png" width="30" alt="Giỏ hàng"></a>
    </div>
</div>

<!-- Navbar chính -->
<nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container">
        <a class="navbar-brand" href="#">Web Bán Đồng Hồ</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="mainNavbar">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link active" href="#">Trang chủ</a></li>
                <li class="nav-item"><a class="nav-link" href="#">Sản phẩm</a></li>
                <li class="nav-item"><a class="nav-link" href="#">Tin tức</a></li>
                <li class="nav-item"><a class="nav-link" href="#">Liên hệ</a></li>
            </ul>
        </div>
    </div>
</nav>

<!-- Thêm CSS vào đây -->
<style>
    .topbar {
        background-color: #f8f9fa;
    }

    .cart-icon img {
        width: 30px;
        height: 30px;
    }

    .navbar {
        margin-top: 20px;
        background-color: #007bff;
    }

    .navbar-nav .nav-link {
        font-size: 16px;
        padding-left: 20px;
        padding-right: 20px;
    }
</style>
