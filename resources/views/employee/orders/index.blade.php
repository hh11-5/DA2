@extends('admin.layouts.app')

@section('title', 'Quản lý đơn hàng')

@section('content')
<div class="container-fluid">
    <div class="row mb-3">
        <div class="col-12">
            <h1 class="h3 mb-0">Quản lý đơn hàng</h1>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="card">
        <div class="card-body">
            <!-- Thêm phần tìm kiếm và lọc -->
            <div class="search-container">
                <div class="search-row">
                    <div class="col-md-6">
                        <form class="d-flex" action="{{ route('employee.orders') }}" method="GET">
                            <input type="text" name="search" class="form-control me-2"
                                   placeholder="Tìm theo mã đơn hàng..."
                                   value="{{ request('search') }}">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-search me-2"></i>
                            </button>
                        </form>
                    </div>
                    <div class="col-md-6">
                        <form action="{{ route('employee.orders') }}" method="GET" id="statusForm">
                            <select class="form-select" name="status" onchange="this.form.submit()">
                                <option value="">Tất cả trạng thái</option>
                                @foreach(\App\Models\DonHang::STATUSES as $key => $value)
                                    <option value="{{ $key }}" {{ (string)request('status') === (string)$key ? 'selected' : '' }}>
                                        {{ $value }}
                                    </option>
                                @endforeach
                            </select>
                        </form>
                    </div>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Mã ĐH</th>
                            <th>Khách hàng</th>
                            <th>Ngày đặt</th>
                            <th>Tổng tiền</th>
                            <th>Trạng thái</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($orders as $order)
                        <tr>
                            <td>{{ $order->iddhang }}</td>
                            <td>
                                {{ $order->khachHang->hokh }} {{ $order->khachHang->tenkh }}
                                <br>
                                <small class="text-muted">{{ $order->khachHang->taiKhoan->sdttk }}</small>
                            </td>
                            <td>{{ $order->ngaydathang->format('d/m/Y H:i') }}</td>
                            <td>{{ number_format($order->tongtien) }}đ</td>
                            <td>
                                <span class="badge bg-{{ \App\Models\DonHang::STATUS_CLASSES[$order->trangthai] }}">
                                    {{ \App\Models\DonHang::STATUSES[$order->trangthai] }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('employee.orders.show', $order->iddhang) }}"
                                   class="btn btn-sm btn-info"
                                   title="Chi tiết">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center">Không có đơn hàng nào</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $orders->withQueryString()->links() }}
            </div>
        </div>
    </div>
</div>

<style>
/* Existing styles */
.badge {
    padding: 8px 12px;
    font-weight: 500;
}
.table > tbody > tr > td {
    vertical-align: middle;
}

/* Search form styles */
.search-container {
    background: #fff;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    margin-bottom: 20px;
}

.form-control {
    height: 42px;
    border-radius: 6px;
    border: 1px solid #dee2e6;
    padding: 0 15px;
    font-size: 14px;
    transition: all 0.3s ease;
}

.form-control:focus {
    border-color: #80bdff;
    box-shadow: 0 0 0 0.2rem rgba(0,123,255,.25);
}

.form-select {
    height: 42px;
    border-radius: 6px;
    border: 1px solid #dee2e6;
    padding: 0 15px;
    font-size: 14px;
    background-color: #fff;
    cursor: pointer;
    transition: all 0.3s ease;
}

.form-select:focus {
    border-color: #80bdff;
    box-shadow: 0 0 0 0.2rem rgba(0,123,255,.25);
}

.btn-primary {
    height: 42px;
    padding: 0 20px;
    font-weight: 500;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 6px;
    transition: all 0.3s ease;
}

.btn-primary:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 6px rgba(0,0,0,0.1);
}

.search-row {
    display: flex;
    gap: 15px;
    align-items: center;
}

@media (max-width: 768px) {
    .search-row {
        flex-direction: column;
    }

    .col-md-6 {
        width: 100%;
        margin-bottom: 10px;
    }
}
</style>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Xử lý form tìm kiếm và lọc trạng thái
    const searchForm = document.querySelector('form[action="{{ route("employee.orders") }}"]');
    const statusForm = document.getElementById('statusForm');
    const statusSelect = statusForm.querySelector('select[name="status"]');

    // Khi thay đổi trạng thái
    statusSelect.addEventListener('change', function() {
        // Lấy giá trị tìm kiếm hiện tại (nếu có)
        const searchValue = new URLSearchParams(window.location.search).get('search');
        if (searchValue) {
            // Thêm hidden input chứa giá trị tìm kiếm vào form status
            const searchInput = document.createElement('input');
            searchInput.type = 'hidden';
            searchInput.name = 'search';
            searchInput.value = searchValue;
            statusForm.appendChild(searchInput);
        }
        statusForm.submit();
    });
});
</script>
@endsection
