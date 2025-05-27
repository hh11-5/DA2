@extends('admin.layouts.app')

@section('title', 'Thống kê doanh thu')

@section('content')
<div class="container-fluid">
    <div class="row mb-3">
        <h1 class="h3 mb-3">Thống kê doanh thu</h1>
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
                    @if(request('type') == 'product')
                        {{-- Chỉ hiển thị biểu đồ kết hợp cho thống kê sản phẩm --}}
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Thống kê doanh thu theo sản phẩm</h3>
                            </div>
                            <div class="card-body">
                                <canvas id="mixedChart"></canvas>
                            </div>
                        </div>
                    @else
                        <canvas id="revenueChart"></canvas>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
@if(request('type') == 'product')
    const ctx = document.getElementById('mixedChart').getContext('2d');
    const chartData = {
        labels: {!! json_encode($data->map(function($item) {
            return $item->sanPham->tensp;
        })) !!},
        datasets: [
            {
                type: 'bar',
                label: 'Số lượng đã bán',
                data: {!! json_encode($data->pluck('total_quantity')) !!},
                backgroundColor: 'rgba(75, 192, 192, 0.5)',
                borderColor: 'rgb(75, 192, 192)',
                borderWidth: 1,
                yAxisID: 'y-quantity'
            },
            {
                type: 'line',
                label: 'Doanh thu',
                data: {!! json_encode($data->pluck('total_revenue')) !!},
                borderColor: 'rgb(255, 99, 132)',
                backgroundColor: 'rgba(255, 99, 132, 0.5)',
                fill: false,
                yAxisID: 'y-revenue'
            }
        ]
    };

    new Chart(ctx, {
        type: 'bar',
        data: chartData,
        options: {
            responsive: true,
            interaction: {
                intersect: false,
                mode: 'index'
            },
            scales: {
                'y-quantity': {
                    type: 'linear',
                    position: 'left',
                    title: {
                        display: true,
                        text: 'Số lượng đã bán'
                    },
                    beginAtZero: true
                },
                'y-revenue': {
                    type: 'linear',
                    position: 'right',
                    title: {
                        display: true,
                        text: 'Doanh thu (VNĐ)'
                    },
                    beginAtZero: true,
                    grid: {
                        drawOnChartArea: false
                    },
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
                            if (context.dataset.type === 'line') {
                                return 'Doanh thu: ' + new Intl.NumberFormat('vi-VN').format(context.raw) + 'đ';
                            }
                            return 'Số lượng: ' + context.raw;
                        }
                    }
                }
            }
        }
        });
@else
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
        type: 'bar',
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
                    display: false
                }
            }
        }
    });
@endif
</script>
@endsection
