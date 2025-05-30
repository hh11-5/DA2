@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="row">
        <div class="col-12 mb-3">
            <div class="d-flex justify-content-between align-items-center">
                <h2>Chi tiết đơn hàng #{{ $order->iddhang }}</h2>
                <div>
                    @if($order->trangthai == 0 || $order->trangthai == 1)
                        <button type="button"
                                class="btn btn-danger me-2"
                                data-bs-toggle="modal"
                                data-bs-target="#cancelOrderModal">
                            <i class="fas fa-times-circle me-2"></i>Hủy đơn hàng
                        </button>
                    @endif
                    <a href="{{ route('orders.history') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Quay lại
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Thông tin đơn hàng -->
        <div class="col-md-4 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Thông tin đơn hàng</h5>
                </div>
                <div class="card-body">
                    <p><strong>Ngày đặt:</strong> {{ $order->ngaydathang->format('d/m/Y H:i') }}</p>
                    <p><strong>Trạng thái:</strong></p>
                    <!-- Replace the status badge with this progress stepper -->
                    <div class="order-progress mb-4">
                        <div class="progress-steps">
                            <div class="step {{ $order->trangthai == 0 ? 'active' : ($order->trangthai > 0 ? 'completed' : '') }} {{ $order->trangthai == 4 ? 'canceled' : '' }}">
                                <div class="step-icon">
                                    <i class="fas fa-clipboard-check"></i>
                                </div>
                                <div class="step-label">Chờ xác nhận</div>
                            </div>
                            <div class="step {{ $order->trangthai == 1 ? 'active' : ($order->trangthai > 1 ? 'completed' : '') }} {{ $order->trangthai == 4 ? 'canceled' : '' }}">
                                <div class="step-icon">
                                    <i class="fas fa-user-check"></i>
                                </div>
                                <div class="step-label">Đã xác nhận</div>
                            </div>
                            <div class="step {{ $order->trangthai == 2 ? 'active' : ($order->trangthai > 2 ? 'completed' : '') }} {{ $order->trangthai == 4 ? 'canceled' : '' }}">
                                <div class="step-icon">
                                    <i class="fas fa-shipping-fast"></i>
                                </div>
                                <div class="step-label">Đang giao</div>
                            </div>
                            <div class="step {{ $order->trangthai == 3 ? 'active' : '' }} {{ $order->trangthai == 4 ? 'canceled' : '' }}">
                                <div class="step-icon">
                                    <i class="fas fa-box-open"></i>
                                </div>
                                <div class="step-label">Đã giao</div>
                            </div>
                        </div>
                        @if($order->trangthai == 4)
                            <div class="order-canceled">
                                <i class="fas fa-times-circle"></i>
                                <span>Đơn hàng đã bị hủy</span>
                            </div>
                        @endif
                    </div>
                    <p><strong>Tạm tính:</strong> {{ number_format($order->tongtien - $order->phivanchuyen) }}đ</p>
                    <p><strong>Phí vận chuyển:</strong> {{ number_format($order->phivanchuyen) }}đ</p>
                    <p class="mb-0"><strong>Tổng cộng:</strong>
                        <span class="text-danger fs-5">{{ number_format($order->tongtien) }}đ</span>
                    </p>
                </div>
            </div>
        </div>

        <!-- Thông tin người nhận -->
        <div class="col-md-4 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Thông tin người nhận</h5>
                </div>
                <div class="card-body">
                    <p><strong>Họ tên:</strong> {{ $order->khachHang->hokh }} {{ $order->khachHang->tenkh }}</p>
                    <p><strong>Số điện thoại:</strong> {{ $order->khachHang->taiKhoan->sdttk ?? 'Chưa cập nhật' }}</p>
                    <p class="mb-0"><strong>Địa chỉ:</strong> {{ $order->khachHang->diachikh }}</p>
                </div>
            </div>
        </div>

        <!-- Thông tin thanh toán -->
        @if($order->trangthai == 0)
        <div class="col-md-4 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Thông tin thanh toán</h5>
                </div>
                <div class="card-body">
                    <div class="text-center mb-3">
                        <img id="qrCode"
                             src=""
                             alt="QR Code"
                             class="img-fluid mb-2"
                             style="max-width: 400px; min-height: 400px; object-fit: contain;"
                             onerror="this.src='{{ asset("images/qr-error.png") }}'">
                        <button class="btn btn-sm btn-outline-primary" onclick="downloadQR()">
                            <i class="fas fa-download me-2"></i>Tải QR
                        </button>
                    </div>
                    <div class="bank-info">
                        <p><strong>Thông tin chuyển khoản:</strong></p>
                        <p class="mb-1"><strong>Ngân hàng:</strong> <span class="text-primary">MB Bank</span></p>
                        <p class="mb-1"><strong>Số tài khoản:</strong> <span class="text-primary">999999999</span></p>
                        <p class="mb-1"><strong>Chủ tài khoản:</strong> <span class="text-primary">WATCH STORE</span></p>
                        <p class="mb-1"><strong>Số tiền:</strong> <span class="text-danger">{{ number_format($order->tongtien) }}đ</span></p>
                        <p class="mb-1"><strong>Nội dung CK:</strong> <span class="text-primary">WS{{ $order->iddhang }}</span></p>
                    </div>
                    <div class="mt-3">
                        <small class="text-muted">
                            <i class="fas fa-info-circle me-1"></i>
                            Vui lòng chuyển khoản chính xác số tiền và nội dung để đơn hàng được xử lý nhanh nhất
                        </small>
                    </div>
                </div>
            </div>
        </div>
        @else
        <div class="col-md-4 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Trạng thái thanh toán</h5>
                </div>
                <div class="card-body">
                    @if($order->trangthai == 4)
                        <div class="text-center text-danger">
                            <i class="fas fa-times-circle fa-3x mb-3"></i>
                            <p class="mb-0">Đơn hàng đã bị hủy</p>
                        </div>
                    @elseif($order->trangthai >= 1)
                        <div class="text-center text-success">
                            <i class="fas fa-check-circle fa-3x mb-3"></i>
                            <p class="mb-0">Đã thanh toán</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        @endif

        <!-- Chi tiết sản phẩm -->
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Chi tiết sản phẩm</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Sản phẩm</th>
                                    <th>Giá</th>
                                    <th>Số lượng</th>
                                    <th>Giảm giá</th>
                                    <th>Thành tiền</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order->chiTietDonHang as $item)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="{{ asset($item->sanPham->hinhsp) }}"
                                                 alt="{{ $item->sanPham->tensp }}"
                                                 class="me-3"
                                                 style="width: 50px; height: 50px; object-fit: contain;">
                                            <div>
                                                <h6 class="mb-0">{{ $item->sanPham->tensp }}</h6>
                                                <small class="text-muted">{{ $item->sanPham->masp }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ number_format($item->dongia) }}đ</td>
                                    <td>{{ $item->soluong }}</td>
                                    <td>{{ number_format($item->giamgia) }}đ</td>
                                    <td>{{ number_format($item->thanhtien) }}đ</td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="4" class="text-end"><strong>Tạm tính:</strong></td>
                                    <td>{{ number_format($order->tongtien - $order->phivanchuyen) }}đ</td>
                                </tr>
                                <tr>
                                    <td colspan="4" class="text-end"><strong>Phí vận chuyển:</strong></td>
                                    <td>{{ number_format($order->phivanchuyen) }}đ</td>
                                </tr>
                                <tr>
                                    <td colspan="4" class="text-end"><strong>Tổng cộng:</strong></td>
                                    <td><strong class="text-danger">{{ number_format($order->tongtien) }}đ</strong></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Thêm Modal xác nhận hủy đơn -->
<div class="modal fade" id="cancelOrderModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Xác nhận hủy đơn hàng</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Bạn có chắc chắn muốn hủy đơn hàng này không?</p>
                <p class="text-muted small">Lưu ý: Hành động này không thể hoàn tác.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                <form action="{{ route('orders.cancel', $order->iddhang) }}" method="POST">
                    @csrf
                    @method('PUT')  <!-- Thay đổi từ PATCH sang PUT -->
                    <button type="submit" class="btn btn-danger">Xác nhận hủy</button>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
.card {
    border-radius: 8px;
    box-shadow: 0 1px 3px rgba(0,0,0,0.1);
}

.card-header {
    background-color: #f8f9fa;
    border-bottom: 1px solid #eee;
}

.badge {
    padding: 6px 10px;
    font-weight: 500;
}

.table > :not(caption) > * > * {
    padding: 1rem;
}

.btn-danger {
    background-color: #dc3545;
    border-color: #dc3545;
    color: white;
    transition: all 0.3s ease;
}

.btn-danger:hover {
    background-color: #bb2d3b;
    border-color: #b02a37;
}

.modal-content {
    border-radius: 8px;
    border: none;
}

.modal-header {
    border-bottom: 1px solid #eee;
    background-color: #f8f9fa;
}

.modal-footer {
    border-top: 1px solid #eee;
}

.order-progress {
    display: flex;
    flex-direction: column;
    padding: 20px 0;
    position: relative;
}

.progress-steps {
    display: flex;
    justify-content: space-between;
    position: relative;
    margin-bottom: 30px;
}

.progress-steps::before {
    content: '';
    position: absolute;
    top: 20px;
    left: 0;
    right: 0;
    height: 2px;
    background: #e2e8f0;
    z-index: 1;
}

.step {
    position: relative;
    z-index: 2;
    flex: 1;
    text-align: center;
}

.step-icon {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: #fff;
    border: 2px solid #e2e8f0;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 10px;
    color: #718096;
    transition: all 0.3s ease;
}

.step-label {
    color: #718096;
    font-size: 0.875rem;
    font-weight: 500;
}

.step.active .step-icon {
    border-color: #fbbf24;
    background: #fbbf24;
    color: white;
    animation: pulse 2s infinite;
}

.step.active .step-label {
    color: #fbbf24;
    font-weight: 600;
}

.step.completed .step-icon {
    border-color: #fbbf24;
    background: #fff;
    color: #fbbf24;
}

.step.completed .step-label {
    color: #fbbf24;
}

.step.active ~ .step .step-icon {
    border-color: #e2e8f0;
    background: #fff;
    color: #718096;
}

.step.canceled .step-icon {
    border-color: #DC2626;
    background: #DC2626;
    color: white;
}

.step.canceled .step-label {
    color: #DC2626;
}

.order-canceled {
    text-align: center;
    color: #DC2626;
    font-weight: 500;
    margin-top: -20px;
    font-size: 1.1rem;
}

.order-canceled i {
    margin-right: 8px;
}

/* Add animation */
.step.active .step-icon {
    animation: pulse 2s infinite;
}

@keyframes pulse {
    0% {
        box-shadow: 0 0 0 0 rgba(251, 191, 36, 0.4);
    }
    70% {
        box-shadow: 0 0 0 10px rgba(251, 191, 36, 0);
    }
    100% {
        box-shadow: 0 0 0 0 rgba(251, 191, 36, 0);
    }
}

.bank-info p {
    font-size: 0.95rem;
    line-height: 1.5;
}

.bank-info .text-primary {
    color: #1a73e8 !important;
    font-weight: 500;
}

.btn-outline-primary {
    color: #1a73e8;
    border-color: #1a73e8;
}

.btn-outline-primary:hover {
    background-color: #1a73e8;
    color: white;
}

#qrCode {
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    padding: 8px;
}
</style>

<script>
@if($order->trangthai == 0)
// Các hàm xử lý QR code giữ nguyên
function initQRCode() {
    const qrElement = document.getElementById('qrCode');
    if (!qrElement) {
        console.error('QR code element not found');
        return;
    }

    generateQRCode();
}

function generateQRCode() {
    const amount = {{ $order->tongtien }};
    const orderId = '{{ $order->iddhang }}';
    const addInfo = `WS${orderId}`;

    // Sử dụng route trong Laravel thay vì gọi trực tiếp API
    fetch(`{{ route('generate.qr') }}`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({
            amount: amount,
            description: addInfo
        })
    })
    .then(response => response.json())
    .then(data => {
        const qrElement = document.getElementById('qrCode');
        if (!qrElement) return;

        // Thay đổi cách kiểm tra response
        if (data.code === 'success' && data.data) { // Thay vì data.code === '200'
            qrElement.src = data.data;
        } else {
            console.error('Error generating QR code:', data);
            qrElement.src = '{{ asset("images/qr-error.png") }}';
        }
    })
    .catch(error => {
        console.error('Error:', error);
        const qrElement = document.getElementById('qrCode');
        if (qrElement) {
            qrElement.src = '{{ asset("images/qr-error.png") }}';
        }
    });
}

function downloadQR() {
    const qrImage = document.getElementById('qrCode');
    if (!qrImage || !qrImage.src) {
        console.error('QR image not found or has no source');
        return;
    }

    const orderId = '{{ $order->iddhang }}';
    const link = document.createElement('a');
    link.href = qrImage.src;
    link.download = `QR_WS${orderId}.png`;
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
}

// Khởi tạo QR code
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initQRCode);
} else {
    initQRCode();
}
@endif
</script>
@endsection
