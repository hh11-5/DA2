@extends('layouts.app')

@section('content')
<div class="container mt-5"> <!-- Thêm margin-top -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Trang chủ</a></li>
            <li class="breadcrumb-item active">Kết quả tìm kiếm</li>
        </ol>
    </nav>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0">
            Hiển thị {{ count($products) }} kết quả cho "{{ $query }}"
        </h4>
    </div>

    @if($products->isEmpty())
        <div class="alert alert-info">
            Không tìm thấy sản phẩm nào phù hợp với từ khóa "{{ $query }}"
        </div>
    @else
        <div class="row">
            <!-- Sidebar filters -->
            <div class="col-md-3">
                <div class="card filter-card">
                    <div class="card-body">
                        <h5 class="filter-title">Bộ lọc tìm kiếm</h5>

                        <!-- Khoảng giá -->
                        <div class="filter-section">
                            <h6>Khoảng giá</h6>
                            <div class="price-range">
                                <div class="price-inputs mb-3">
                                    <div class="d-flex align-items-center mb-2">
                                        <span class="me-2">Từ:</span>
                                        <input type="number" class="form-control custom-input" id="minPriceInput"
                                               min="0" max="500000000" step="1000000" value="0">
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <span class="me-2">Đến:</span>
                                        <input type="number" class="form-control custom-input" id="maxPriceInput"
                                               min="0" max="500000000" step="1000000" value="500000000">
                                    </div>
                                </div>
                                <div class="price-slider">
                                    <input type="range" class="form-range custom-range" id="priceRange"
                                           min="0" max="500000000" step="1000000"
                                           value="500000000">
                                    <div class="d-flex justify-content-between mt-2">
                                        <small class="text-muted">0đ</small>
                                        <small class="text-muted">500 triệu</small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Chất liệu vỏ -->
                        <div class="filter-section">
                            <h6>Chất liệu vỏ</h6>
                            <div class="mb-3">
                                <div class="form-check">
                                    <input class="form-check-input filter-check" type="checkbox"
                                           name="clieuvo" value="Thép không gỉ 904L">
                                    <label class="form-check-label">Thép không gỉ 904L</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input filter-check" type="checkbox"
                                           name="clieuvo" value="Thép không gỉ và vàng">
                                    <label class="form-check-label">Thép không gỉ và vàng</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input filter-check" type="checkbox"
                                           name="clieuvo" value="Thép không gỉ">
                                    <label class="form-check-label">Thép không gỉ</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input filter-check" type="checkbox"
                                           name="clieuvo" value="Vàng Everose 18k">
                                    <label class="form-check-label">Vàng Everose 18k</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input filter-check" type="checkbox"
                                           name="clieuvo" value="Vàng 18k">
                                    <label class="form-check-label">Vàng 18k</label>
                                </div>
                            </div>
                        </div>

                        <!-- Nút lọc -->
                        <button class="btn btn-buy-now w-100 mt-3" id="applyFilters">
                            <i class="fas fa-filter me-2"></i>Áp dụng
                        </button>
                    </div>
                </div>
            </div>

            <!-- Product grid -->
            <div class="col-md-9">
                <div class="row row-cols-2 row-cols-md-3 g-4" id="productsContainer">
                    @foreach($products as $product)
                    <div class="col">
                        <a href="{{ route('products.show', $product->idsp) }}" class="text-decoration-none">
                            <div class="card h-100">
                                <img src="{{ asset($product->hinhsp) }}" class="card-img-top" alt="{{ $product->tensp }}">
                                <div class="card-body">
                                    <h5 class="card-title text-dark">{{ $product->tensp }}</h5>
                                    <p class="card-text text-muted">Giá: {{ number_format($product->gia, 0, ',', '.') }}đ</p>
                                    <small class="text-muted">{{ $product->nhasanxuat->tennhasx }}</small>
                                </div>
                            </div>
                        </a>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif
</div>

<style>
/* Đặt btn-buy-now lên đầu để ưu tiên cao nhất */
.btn-buy-now {
    background-color: #fbbf24 !important; /* Thêm !important để đảm bảo được áp dụng */
    color: #1a202c !important;
    padding: 12px 30px;
    border-radius: 8px;
    font-weight: 600;
    transition: all 0.3s ease;
    border: none;
}

.btn-buy-now:hover {
    background-color: #f59e0b !important;
    transform: translateY(-2px);
    color: #1a202c !important;
}

.card {
    transition: all 0.3s ease;
    border: none;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}

.card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 16px rgba(0,0,0,0.2);
}

.card-img-top {
    height: 200px;
    object-fit: contain;
    padding: 1rem;
    background-color: #ffffff;
}

.card-body {
    padding: 1.25rem;
}

.card-title {
    font-size: 1rem;
    margin-bottom: 0.5rem;
}

.filter-card {
    border: none;
    border-radius: 12px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    margin-bottom: 20px;
}

.filter-title {
    color: #2d3748;
    font-size: 1.1rem;
    margin-bottom: 1.5rem;
}

.filter-section {
    margin-bottom: 1.5rem;
    padding-bottom: 1rem;
    border-bottom: 1px solid #e2e8f0;
}

.filter-section:last-child {
    border-bottom: none;
}

.filter-section h6 {
    color: #4a5568;
    margin-bottom: 1rem;
}

.form-check-label {
    color: #4a5568;
    cursor: pointer;
}

.price-range {
    padding: 10px 0;
}

#priceRange {
    width: 100%;
}

.breadcrumb {
    background: transparent;
    padding: 0;
    margin-bottom: 1.5rem;
}

.breadcrumb-item a {
    color: #475569;
    text-decoration: none;
    font-weight: 500;
}

.breadcrumb-item a:hover {
    color: #1e40af;
}

.breadcrumb-item.active {
    color: #64748b;
}

/* Thêm animation cho số lượng kết quả */
.search-results {
    animation: fadeInUp 0.3s ease-out;
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.custom-input {
    border-radius: 8px;
    border: 1px solid #e2e8f0;
    padding: 8px 12px;
    transition: all 0.3s ease;
}

.custom-input:focus {
    border-color: #fbbf24;
    box-shadow: 0 0 0 2px rgba(251, 191, 36, 0.2);
}

.custom-range {
    height: 6px;
    -webkit-appearance: none;
    background: #e2e8f0;
    border-radius: 3px;
    outline: none;
}

.custom-range::-webkit-slider-thumb {
    -webkit-appearance: none;
    appearance: none;
    width: 18px;
    height: 18px;
    background: #fbbf24;
    border-radius: 50%;
    cursor: pointer;
    transition: all 0.3s ease;
}

.custom-range::-webkit-slider-thumb:hover {
    background: #f59e0b;
    transform: scale(1.1);
}

.custom-range::-moz-range-thumb {
    width: 18px;
    height: 18px;
    background: #fbbf24;
    border-radius: 50%;
    cursor: pointer;
    transition: all 0.3s ease;
    border: none;
}

.custom-range::-moz-range-thumb:hover {
    background: #f59e0b;
    transform: scale(1.1);
}
</style>

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const priceRange = document.getElementById('priceRange');
    const minPriceInput = document.getElementById('minPriceInput');
    const maxPriceInput = document.getElementById('maxPriceInput');

    // Format price
    function formatPrice(price) {
        return new Intl.NumberFormat('vi-VN', {
            style: 'currency',
            currency: 'VND'
        }).format(price);
    }

    // Update price display
    priceRange.addEventListener('input', function() {
        maxPriceInput.value = this.value;
    });

    minPriceInput.addEventListener('input', function() {
        priceRange.min = this.value;
    });

    maxPriceInput.addEventListener('input', function() {
        priceRange.max = this.value;
        priceRange.value = this.value;
    });

    // Apply filters
    document.getElementById('applyFilters').addEventListener('click', function() {
        const filters = {
            minPrice: document.getElementById('minPriceInput').value,
            maxPrice: document.getElementById('maxPriceInput').value,
            clieuvo: Array.from(document.querySelectorAll('input[name="clieuvo"]:checked'))
                         .map(cb => cb.value)
        };

        // Thêm token CSRF
        const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        fetch('/filter-products', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': token
            },
            body: JSON.stringify(filters)
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(products => {
            updateProductsDisplay(products);
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Có lỗi xảy ra khi lọc sản phẩm');
        });
    });
});

// Hàm hiển thị sản phẩm
function updateProductsDisplay(products) {
    const container = document.getElementById('productsContainer');
    if (products.length === 0) {
        container.innerHTML = `
            <div class="col-12">
                <div class="alert alert-info">
                    Không tìm thấy sản phẩm nào phù hợp với bộ lọc
                </div>
            </div>
        `;
    } else {
        container.innerHTML = products.map(product => `
            <div class="col">
                <a href="/products/${product.idsp}" class="text-decoration-none">
                    <div class="card h-100">
                        <img src="${product.hinhsp}" class="card-img-top" alt="${product.tensp}">
                        <div class="card-body">
                            <h5 class="card-title text-dark">${product.tensp}</h5>
                            <p class="card-text text-muted">Giá: ${new Intl.NumberFormat('vi-VN').format(product.gia)}đ</p>
                            <small class="text-muted">${product.nhasanxuat.tennhasx}</small>
                        </div>
                    </div>
                </a>
            </div>
        `).join('');
    }
}
</script>
@endsection
