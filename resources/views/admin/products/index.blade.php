@extends('admin.layouts.app')

@section('title', 'Quản lý sản phẩm')

@section('styles')
<style>
    .input-group-text,
    .form-control,
    .form-select,
    .btn {
        height: 38px;
    }

    .input-group {
        align-items: stretch;
    }
</style>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row mb-3">
        <div class="col-12 d-flex justify-content-between align-items-center">
            <h1 class="h3 mb-0">Quản lý sản phẩm</h1>
            <a href="{{ route('admin.products.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i>Thêm sản phẩm mới
            </a>
        </div>
    </div>

    <!-- Add search form here -->
    <div class="card mb-3">
        <div class="card-body">
            <form action="{{ route('admin.products') }}" method="GET" class="row g-3">
                <div class="col-md-2">
                    <div class="input-group">
                        <span class="input-group-text">Mã SP</span>
                        <input type="text" name="masp" class="form-control" value="{{ request('masp') }}" placeholder="Nhập mã...">
                    </div>
                </div>

                <div class="col-md-2">
                    <div class="input-group">
                        <span class="input-group-text">Tên SP</span>
                        <input type="text" name="tensp" class="form-control" value="{{ request('tensp') }}" placeholder="Nhập tên...">
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="input-group">
                        <span class="input-group-text">Giá</span>
                        <input type="number" name="gia_min" class="form-control" value="{{ request('gia_min') }}" placeholder="Từ">
                        <input type="number" name="gia_max" class="form-control" value="{{ request('gia_max') }}" placeholder="Đến">
                    </div>
                </div>

                <div class="col-md-2">
                    <div class="input-group">
                        <span class="input-group-text">Hiệu</span>
                        <select name="idnhasx" class="form-select">
                            <option value="">Tất cả</option>
                            @foreach($manufacturers as $manufacturer)
                                <option value="{{ $manufacturer->idnhasx }}" {{ request('idnhasx') == $manufacturer->idnhasx ? 'selected' : '' }}>
                                    {{ $manufacturer->tennhasx }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-auto">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class->alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Mã SP</th>
                            <th>Hình ảnh</th>
                            <th>Tên sản phẩm</th>
                            <th>Giá</th>
                            <th>Thương hiệu</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($products as $product)
                        <tr>
                            <td>{{ $product->masp }}</td>
                            <td>
                                <img src="{{ asset($product->hinhsp) }}"
                                     alt="{{ $product->tensp }}"
                                     style="width: 50px; height: 50px; object-fit: contain;">
                            </td>
                            <td>{{ $product->tensp }}</td>
                            <td>{{ number_format($product->gia) }}đ</td>
                            <td>{{ $product->nhasanxuat->tennhasx }}</td>
                            <td>
                                <a href="{{ route('admin.products.edit', $product->idsp) }}"
                                   class="btn btn-sm btn-info">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.products.delete', $product->idsp) }}"
                                      method="POST"
                                      class="d-inline"
                                      onsubmit="return confirm('Bạn có chắc muốn xóa sản phẩm này?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $products->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
