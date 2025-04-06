@extends('layouts.app')

@section('content')
<!-- Slider sản phẩm nổi bật -->
<div id="highlightCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="4000">
    <div class="carousel-indicators">
        <button type="button" data-bs-target="#highlightCarousel" data-bs-slide-to="0" class="active"></button>
        <button type="button" data-bs-target="#highlightCarousel" data-bs-slide-to="1"></button>
    </div>
    <div class="carousel-inner">
        <div class="carousel-item active">
            <img src="https://via.placeholder.com/1200x500/FF5733/FFFFFF?text=Sản+Phẩm+Nổi+Bật+1" class="d-block w-100" alt="Sản phẩm 1">
            <div class="carousel-caption d-none d-md-block">
                <h3>Đồng Hồ Cao Cấp</h3>
            </div>
        </div>
        <div class="carousel-item">
            <img src="https://via.placeholder.com/1200x500/3498DB/FFFFFF?text=Sản+Phẩm+Nổi+Bật+2" class="d-block w-100" alt="Sản phẩm 2">
            <div class="carousel-caption d-none d-md-block">
                <h3>Đồng Hồ Thể Thao</h3>
            </div>
        </div>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#highlightCarousel" data-bs-slide="prev">
        <span class="carousel-control-prev-icon"></span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#highlightCarousel" data-bs-slide="next">
        <span class="carousel-control-next-icon"></span>
    </button>
</div>

<div class="container mt-4">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-md-3 sidebar">
            <h4>Bộ lọc sản phẩm</h4>

            <h5>Thể loại</h5>
            <ul class="list-group mb-3">
                <li class="list-group-item"><input type="checkbox"> Đồng hồ nam</li>
                <li class="list-group-item"><input type="checkbox"> Đồng hồ nữ</li>
            </ul>

            <h5>Khoảng giá</h5>
            <input type="range" class="form-range mb-3" id="priceRange" min="0" max="50000000" step="1000000" oninput="updatePriceValue()">
            <p>Giá: <span id="priceValue">0</span> - 50,000,000 VNĐ</p>

            <h5>Sắp xếp giá</h5>
            <select class="form-select mb-3">
                <option value="asc">Giá từ thấp đến cao</option>
                <option value="desc">Giá từ cao đến thấp</option>
            </select>

            <button class="btn btn-primary w-100">Áp dụng bộ lọc</button>
        </div>

        <!-- Danh sách sản phẩm -->
        <div class="col-md-9">
            <h2 class="text-center mb-4">Danh sách sản phẩm</h2>
            <div class="row">
                @for ($i = 0; $i < 6; $i++)
                    <div class="col-md-4 mb-4">
                        <div class="card product-card">
                            <img src="https://via.placeholder.com/150?text=?" class="card-img-top">
                            <div class="card-body">
                                <h5>Sản phẩm ?</h5>
                                <p>Giá: ? VNĐ</p>
                                <a href="#" class="btn btn-primary">Xem chi tiết</a>
                            </div>
                        </div>
                    </div>
                @endfor
            </div>
        </div>
    </div>
</div>

<script>
    function updatePriceValue() {
        document.getElementById("priceValue").innerText = document.getElementById("priceRange").value;
    }
</script>
@endsection

@section('styles')
<style>
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
    .carousel-control-prev, .carousel-control-next {
        width: 60px;
        height: 60px;
        background: rgba(0, 0, 0, 0.7);
        border-radius: 50%;
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
</style>
@endsection
