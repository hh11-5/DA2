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
                            <div class="price-options">
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="radio" name="priceRange" 
                                           id="price1" value="1000000-5000000">
                                    <label class="form-check-label" for="price1">
                                        1 triệu - 5 triệu
                                    </label>
                                </div>
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="radio" name="priceRange" 
                                           id="price2" value="5000000-10000000">
                                    <label class="form-check-label" for="price2">
                                        5 triệu - 10 triệu
                                    </label>
                                </div>
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="radio" name="priceRange" 
                                           id="price3" value="10000000-20000000">
                                    <label class="form-check-label" for="price3">
                                        10 triệu - 20 triệu
                                    </label>
                                </div>
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="radio" name="priceRange" 
                                           id="price4" value="20000000-30000000">
                                    <label class="form-check-label" for="price4">
                                        20 triệu - 30 triệu
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="priceRange" 
                                           id="price5" value="30000000-50000000">
                                    <label class="form-check-label" for="price5">
                                        30 triệu - 50 triệu
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- Chất liệu vỏ -->
                        <div class="filter-section">
                            <h6>Chất liệu vỏ</h6>
                            <div class="mb-3">
                                @foreach($chatLieuVos as $clieuvo)
                                    <div class="form-check">
                                        <input class="form-check-input filter-check" 
                                               type="checkbox"
                                               name="clieuvo[]" 
                                               value="{{ $clieuvo }}"
                                               id="clieuvo_{{ Str::slug($clieuvo) }}">
                                        <label class="form-check-label" for="clieuvo_{{ Str::slug($clieuvo) }}">
                                            {{ $clieuvo }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Nút lọc -->
                        <div class="d-flex gap-2 mt-3">
                            <button class="btn btn-buy-now flex-grow-1" id="applyFilters">
                                <i class="fas fa-filter me-2"></i>Áp dụng
                            </button>
                            <button class="btn btn-outline-secondary" id="resetFilters">
                                <i class="fas fa-undo me-2"></i>Đặt lại
                            </button>
                        </div>

                        <!-- Add debug element -->
                        <div id="debug-info" style="display: none;" class="alert alert-info mt-2"></div>
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
                                    <p class="card-text" style="color: #dc2626; font-weight: bold;">
                                        {{ number_format($product->gia, 0, ',', '.') }}đ
                                    </p>
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

/* Thêm vào phần style */
.price-options {
    padding: 0.5rem 0;
}

.price-options .form-check {
    padding-left: 1.8rem;
}

.price-options .form-check-input {
    margin-left: -1.8rem;
}

.price-options .form-check-label {
    color: #4a5568;
    font-size: 0.95rem;
    cursor: pointer;
}

.price-options .form-check-input:checked + .form-check-label {
    color: #1a202c;
    font-weight: 500;
}

/* Style cho nút đặt lại */
.btn-outline-secondary {
    border: 1px solid #e2e8f0;
    color: #4a5568;
    background: transparent;
    padding: 12px 20px;
    border-radius: 8px;
    font-weight: 500;
    transition: all 0.3s ease;
}

.btn-outline-secondary:hover {
    background-color: #f8fafc;
    border-color: #cbd5e1;
    color: #1a202c;
}

/* Điều chỉnh layout cho container nút */
.d-flex.gap-2 {
    gap: 0.75rem !important;
}

.flex-grow-1 {
    flex-grow: 1 !important;
}
</style>

@section('scripts')
<script>
// Lưu trạng thái ban đầu khi tải trang
const initialProductCount = {{ count($products) }};
const query = @json($query);
const initialProductsHTML = document.getElementById('productsContainer').innerHTML;

document.getElementById('applyFilters').addEventListener('click', function() {
    const selectedPriceRange = document.querySelector('input[name="priceRange"]:checked');
    const selectedMaterials = Array.from(document.querySelectorAll('input[name="clieuvo[]"]:checked'))
        .map(cb => cb.value);

    const filters = {};
    
    if (selectedPriceRange) {
        filters.priceRange = selectedPriceRange.value;
        console.log('Selected price range:', selectedPriceRange.value);
    }

    if (selectedMaterials.length > 0) {
        filters.clieuvo = selectedMaterials;
    }

    // Debug log
    console.log('Sending filters:', filters);

    fetch('/filter-products', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify(filters)
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json();
    })
    .then(data => {
        console.log('Received data:', data);
        
        if (data.error) {
            const container = document.getElementById('productsContainer');
            container.innerHTML = `
                <div class="col-12">
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i>
                        ${data.error}
                    </div>
                </div>
            `;
            return;
        }
        
        updateProductDisplay(data, selectedPriceRange, selectedMaterials);
    })
    .catch(error => {
        console.error('Error:', error);
        const container = document.getElementById('productsContainer');
        container.innerHTML = `
            <div class="col-12">
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    Có lỗi xảy ra khi lọc sản phẩm
                </div>
            </div>
        `;
    });
});

// Hàm cập nhật hiển thị sản phẩm
function updateProductDisplay(products, selectedPriceRange, selectedMaterials) {
    const container = document.getElementById('productsContainer');
    const resultCount = document.querySelector('.d-flex h4');
    
    // Tạo text hiển thị bộ lọc
    let filterText = '';
    if (selectedPriceRange) {
        const priceLabel = selectedPriceRange.nextElementSibling.textContent.trim();
        filterText += `khoảng giá ${priceLabel}`;
    }
    if (selectedMaterials.length > 0) {
        filterText += filterText ? ' và ' : '';
        filterText += `chất liệu vỏ: ${selectedMaterials.join(', ')}`;
    }

    // Cập nhật số lượng kết quả
    resultCount.innerHTML = `Hiển thị ${products.length} sản phẩm${filterText ? ` với ${filterText}` : ''}`;
    
    // Hiển thị sản phẩm
    if (products.length === 0) {
        container.innerHTML = `
            <div class="col-12">
                <div class="alert alert-info">
                    <i class="fas fa-info-circle me-2"></i>
                    Không tìm thấy sản phẩm nào${filterText ? ` với ${filterText}` : ''}
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
                            <p class="card-text" style="color: #dc2626; font-weight: bold;">
                                ${new Intl.NumberFormat('vi-VN').format(product.gia)}đ
                            </p>
                        </div>
                    </div>
                </a>
            </div>
        `).join('');
    }
}

// Hàm hiển thị lỗi
function showError() {
    const container = document.getElementById('productsContainer');
    container.innerHTML = `
        <div class="col-12">
            <div class="alert alert-danger">
                <i class="fas fa-exclamation-circle me-2"></i>
                Có lỗi xảy ra khi lọc sản phẩm
            </div>
        </div>
    `;
}

// Xử lý nút đặt lại
document.getElementById('resetFilters').addEventListener('click', function() {
    // Bỏ chọn tất cả radio buttons khoảng giá
    document.querySelectorAll('input[name="priceRange"]').forEach(radio => {
        radio.checked = false;
    });

    // Bỏ chọn tất cả checkboxes chất liệu vỏ
    document.querySelectorAll('input[name="clieuvo[]"]').forEach(checkbox => {
        checkbox.checked = false;
    });

    // Reset hiển thị về ban đầu
    const searchQuery = query || ''; // Nếu query là null thì gán chuỗi rỗng
    const displayText = searchQuery 
        ? `Hiển thị ${initialProductCount} kết quả cho "${searchQuery}"`
        : `Hiển thị ${initialProductCount} sản phẩm`;

    document.querySelector('.d-flex h4').innerHTML = displayText;
    document.getElementById('productsContainer').innerHTML = initialProductsHTML;
});
</script>
@endsection
