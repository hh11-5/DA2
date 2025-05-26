@extends('admin.layouts.app')

@section('title', 'Thống kê doanh thu')

@section('content')
<div class="container-fluid">
    <div class="row mb-3">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form method="GET" class="row g-3 align-items-end">
                        <div class="col-md-3">
                            <label class="form-label">Loại thống kê</label>
                            <select name="type" class="form-select" onchange="this.form.submit()">
                                <option value="daily" {{ request('type') == 'daily' ? 'selected' : '' }}>Theo ngày</option>
                                <option value="monthly" {{ request('type') == 'monthly' ? 'selected' : '' }}>Theo tháng</option>
                                <option value="quarterly" {{ request('type') == 'quarterly' ? 'selected' : '' }}>Theo quý</option>
                                <option value="yearly" {{ request('type') == 'yearly' ? 'selected' : '' }}>Theo năm</option>
                                <option value="customer" {{ request('type') == 'customer' ? 'selected' : '' }}>Theo khách hàng</option>
                                <option value="product" {{ request('type') == 'product' ? 'selected' : '' }}>Theo sản phẩm</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Từ ngày</label>
                            <input type="date" name="start_date" class="form-control"
                                   value="{{ request('start_date', now()->format('Y-m-d')) }}">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Đến ngày</label>
                            <input type="date" name="end_date" class="form-control"
                                   value="{{ request('end_date', now()->format('Y-m-d')) }}">
                        </div>
                        <div class="col-md-3">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-filter me-2"></i>Lọc
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    @if(request('type') == 'customer')
                        <h5>Top khách hàng</h5>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Khách hàng</th>
                                        <th>Số đơn hàng</th>
                                        <th>Tổng chi tiêu</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($data as $item)
                                    <tr>
                                        <td>{{ $item->khachHang->hokh }} {{ $item->khachHang->tenkh }}</td>
                                        <td>{{ $item->total_orders }}</td>
                                        <td>{{ number_format($item->total_spent) }}đ</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @elseif(request('type') == 'product')
                        <h5>Top sản phẩm bán chạy</h5>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Sản phẩm</th>
                                        <th>Số lượng đã bán</th>
                                        <th>Doanh thu</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($data as $item)
                                    <tr>
                                        <td>{{ $item->sanPham->tensp }}</td>
                                        <td>{{ $item->total_quantity }}</td>
                                        <td>{{ number_format($item->total_revenue) }}đ</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <canvas id="revenueChart"></canvas>
                    @endif
                </div>
            </div>
        </div>
    </div>

    @if(config('app.debug'))
    <div class="card mb-3">
        <div class="card-body">
            <h5>Debug Information</h5>
            <p>Start Date: {{ $startDate }}</p>
            <p>End Date: {{ $endDate }}</p>
            <p>Data Count: {{ count($data) }}</p>
            @if(count($data) > 0)
                <p>First Record: {{ json_encode($data->first()) }}</p>
            @endif
        </div>
    </div>
    @endif
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
@if(!in_array(request('type', 'daily'), ['customer', 'product']))
    const ctx = document.getElementById('revenueChart').getContext('2d');

    const chartData = {
        labels: {!! json_encode($data->map(function($item) {
            switch(request('type', 'daily')) {
                case 'daily':
                    return Carbon\Carbon::parse($item->date)->format('d/m/Y');
                case 'monthly':
                    return "Tháng {$item->month}/{$item->year}";
                case 'quarterly':
                    return "Q{$item->quarter}/{$item->year}";
                case 'yearly':
                    return $item->year;
                default:
                    return Carbon\Carbon::parse($item->date)->format('d/m/Y');
            }
        })) !!},
        datasets: [{
            label: 'Doanh thu (VNĐ)',
            data: {!! json_encode($data->pluck('revenue')) !!},
            backgroundColor: 'rgba(75, 192, 192, 0.5)',
            borderColor: 'rgb(75, 192, 192)',
            borderWidth: 1,
            borderRadius: 5,
            maxBarThickness: 50
        }]
    };

    new Chart(ctx, {
        type: 'bar', // Thay đổi type từ 'line' thành 'bar'
        data: chartData,
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return new Intl.NumberFormat('vi-VN').format(value) + 'đ';
                        }
                    }
                }
            },
            plugins: {
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return 'Doanh thu: ' + new Intl.NumberFormat('vi-VN').format(context.raw) + 'đ';
                        }
                    }
                },
                legend: {
                    display: false // Ẩn legend vì chỉ có 1 dataset
                }
            }
        }
    });
@endif
</script>
@endsection
