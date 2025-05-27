@extends('layouts.app')

@section('scripts')
<script>
    // Đợi cho đến khi document load xong
    document.addEventListener('DOMContentLoaded', function() {
        // Xử lý form hủy đơn hàng
        const cancelForms = document.querySelectorAll('.cancel-order-form');
        cancelForms.forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();

                const modal = document.createElement('div');
                modal.className = 'modal';
                modal.style.display = 'block';
                modal.style.backgroundColor = 'rgba(0,0,0,0.5)';

                modal.innerHTML = `
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Xác nhận hủy đơn hàng</h5>
                                <button type="button" class="btn-close" onclick="this.closest('.modal').remove()"></button>
                            </div>
                            <div class="modal-body">
                                <p>Bạn có chắc chắn muốn hủy đơn hàng này không?</p>
                                <p class="text-muted">Lưu ý: Hành động này không thể hoàn tác.</p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary"
                                        onclick="closeModal(this.closest('.modal'))">Đóng</button>
                                <button type="button" class="btn btn-danger"
                                        onclick="submitCancelForm(this)">Xác nhận hủy</button>
                            </div>
                        </div>
                    </div>
                `;

                document.body.appendChild(modal);
                // Thêm class show sau khi append để kích hoạt animation
                setTimeout(() => modal.classList.add('show'), 50);
            });
        });
    });

    function submitCancelForm(button) {
        const modal = button.closest('.modal');
        const form = document.querySelector('.cancel-order-form');
        form.submit();
        modal.remove();
    }

    function closeModal(modal) {
        modal.classList.remove('show');
        setTimeout(() => modal.remove(), 300); // Đợi animation kết thúc
    }

    // Hiển thị thông báo thành công/lỗi
    @if(session('success'))
        const successAlert = document.createElement('div');
        successAlert.className = 'alert alert-success alert-dismissible fade position-fixed top-0 end-0 m-3';
        successAlert.innerHTML = `
            {{ session('success') }}
            <button type="button" class="btn-close" onclick="hideAlert(this.closest('.alert'))"></button>
        `;
        document.body.appendChild(successAlert);
        setTimeout(() => hideAlert(successAlert), 3000);
    @endif

    @if(session('error'))
        const errorAlert = document.createElement('div');
        errorAlert.className = 'alert alert-danger alert-dismissible fade show position-fixed top-0 end-0 m-3';
        errorAlert.innerHTML = `
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        `;
        document.body.appendChild(errorAlert);
        setTimeout(() => errorAlert.remove(), 3000);
    @endif

    function hideAlert(alert) {
        alert.classList.add('hide');
        setTimeout(() => alert.remove(), 500); // Đợi animation kết thúc
    }
</script>

<style>
.modal {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    z-index: 1050;
    opacity: 0;
    transition: opacity 0.3s ease;
}

.modal.show {
    opacity: 1;
}

.modal-dialog {
    position: relative;
    width: auto;
    margin: 1.75rem auto;
    max-width: 500px;
    transform: translateY(-100px);
    transition: transform 0.3s ease;
}

.modal.show .modal-dialog {
    transform: translateY(0);
}

.modal-content {
    position: relative;
    background-color: #fff;
    border-radius: 0.3rem;
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
}

@keyframes slideInDown {
    from {
        transform: translateY(-100%);
        opacity: 0;
    }
    to {
        transform: translateY(0);
        opacity: 1;
    }
}

.alert {
    animation: slideInDown 0.5s ease forwards;
}

.alert.hide {
    animation: slideOutUp 0.5s ease forwards;
}

@keyframes slideOutUp {
    from {
        transform: translateY(0);
        opacity: 1;
    }
    to {
        transform: translateY(-100%);
        opacity: 0;
    }
}

.alert {
    z-index: 1060;
}
</style>
@endsection

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Lịch sử đơn hàng</h2>

    <!-- Thanh trạng thái -->
    <div class="order-status-tabs mb-4">
        <div class="nav nav-pills">
            <a href="{{ route('orders.history') }}"
               class="nav-link {{ !request('status') ? 'active' : '' }}">
                Tất cả
            </a>
            <a href="{{ route('orders.history', ['status' => 0]) }}"
               class="nav-link {{ request('status') == '0' ? 'active' : '' }}">
                Chờ thanh toán
                @if($pendingCount > 0)
                    <span class="badge bg-secondary ms-1">{{ $pendingCount }}</span>
                @endif
            </a>
            <a href="{{ route('orders.history', ['status' => 1]) }}"
               class="nav-link {{ request('status') == '1' ? 'active' : '' }}">
                Vận chuyển
                @if($shippingCount > 0)
                    <span class="badge bg-primary ms-1">{{ $shippingCount }}</span>
                @endif
            </a>
            <a href="{{ route('orders.history', ['status' => 2]) }}"
               class="nav-link {{ request('status') == '2' ? 'active' : '' }}">
                Chờ giao hàng
                @if($deliveringCount > 0)
                    <span class="badge bg-info ms-1">{{ $deliveringCount }}</span>
                @endif
            </a>
            <a href="{{ route('orders.history', ['status' => 3]) }}"
               class="nav-link {{ request('status') == '3' ? 'active' : '' }}">
                Hoàn thành
            </a>
            <a href="{{ route('orders.history', ['status' => 4]) }}"
               class="nav-link {{ request('status') == '4' ? 'active' : '' }}">
                Đã hủy
            </a>
        </div>
    </div>

    @if($orders->isEmpty())
        <div class="alert alert-info">
            Bạn chưa có đơn hàng nào.
        </div>
    @else
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Mã đơn hàng</th>
                        <th>Ngày đặt</th>
                        <th>Tổng tiền</th>
                        <th>Phí vận chuyển</th>
                        <th>Trạng thái</th>
                        <th>Chi tiết</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $order)
                    <tr>
                        <td>{{ $order->iddhang }}</td>
                        <td>
                            @if($order->ngaydathang instanceof \Carbon\Carbon)
                                {{ $order->ngaydathang->format('d/m/Y H:i') }}
                            @else
                                {{ \Carbon\Carbon::parse($order->ngaydathang)->format('d/m/Y H:i') }}
                            @endif
                        </td>
                        <td>{{ number_format($order->tongtien) }}đ</td>
                        <td>{{ number_format($order->phivanchuyen) }}đ</td>
                        <td>
                            @php
                                $statusClass = [
                                    0 => 'secondary',  // Chờ xác nhận
                                    1 => 'info',       // Đã xác nhận
                                    2 => 'primary',    // Đang giao
                                    3 => 'success',    // Đã giao
                                    4 => 'danger'      // Đã hủy
                                ];
                                $statusText = [
                                    0 => 'Chờ xác nhận',
                                    1 => 'Đã xác nhận',
                                    2 => 'Đang giao',
                                    3 => 'Đã giao',
                                    4 => 'Đã hủy'
                                ];
                            @endphp
                            <span class="badge bg-{{ $statusClass[$order->trangthai] }}">
                                {{ $statusText[$order->trangthai] }}
                            </span>
                        </td>
                        <td>
                            <div class="d-flex gap-2">
                                <a href="{{ route('orders.show', $order->iddhang) }}"
                                   class="btn btn-sm btn-outline-primary">
                                    Xem chi tiết
                                </a>
                                @if($order->trangthai == 0 || $order->trangthai == 1)
                                    <form action="{{ route('orders.cancel', $order->iddhang) }}"
                                          method="POST"
                                          class="d-inline cancel-order-form">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="btn btn-sm btn-outline-danger">Hủy đơn</button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            @if($orders->hasPages())
                <div class="mt-4">
                    {{ $orders->links() }}
                </div>
            @endif
        </div>
    @endif
</div>

<style>
.order-status-tabs {
    background: #f8fafc;
    padding: 1rem;
    border-radius: 10px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.05);
    border: 1px solid #e2e8f0;
}

.nav-pills {
    gap: 0.5rem;
}

.nav-pills .nav-link {
    color: #64748b;
    padding: 0.75rem 1.25rem;
    border-radius: 8px;
    transition: all 0.3s ease;
    font-weight: 500;
    background: white;
    border: 1px solid #e2e8f0;
}

.nav-pills .nav-link:hover {
    background: linear-gradient(145deg, #2c3e50, #34495e);
    color: white;
    transform: translateY(-1px);
    border: none;
}

.nav-pills .nav-link.active {
    background: linear-gradient(145deg, #2c3e50, #34495e);
    color: white;
    border: none;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
}

.badge {
    font-size: 0.75rem;
    padding: 0.25em 0.6em;
    font-weight: 600;
    border-radius: 6px;
}

/* Animation cho active state */
.nav-pills .nav-link.active {
    animation: gentlePulse 2s infinite;
}

@keyframes gentlePulse {
    0% {
        box-shadow: 0 4px 12px rgba(37, 99, 235, 0.2);
    }
    50% {
        box-shadow: 0 4px 20px rgba(37, 99, 235, 0.4);
    }
    100% {
        box-shadow: 0 4px 12px rgba(37, 99, 235, 0.2);
    }
}

.table > tbody > tr > td {
    vertical-align: middle;
}

.btn-outline-primary {
    color: #fbbf24;
    border-color: #fbbf24;
}

.btn-outline-primary:hover {
    background: #f59e0b;
    transform: translateY(-2px);
    border-color: #f59e0b;
}
</style>
@endsection
