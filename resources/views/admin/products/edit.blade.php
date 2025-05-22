@extends('admin.layouts.app')

@section('title', 'Sửa sản phẩm')

@section('content')
<div class="container-fluid">
    <div class="row mb-3">
        <div class="col-md-12">
            <h1 class="h3">Sửa sản phẩm: {{ $product->tensp }}</h1>
        </div>
    </div>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.products.update', $product->idsp) }}"
                  method="POST"
                  enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Mã sản phẩm</label>
                            <input type="text" name="masp" class="form-control"
                                   value="{{ $product->masp }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Tên sản phẩm</label>
                            <input type="text" name="tensp" class="form-control"
                                   value="{{ $product->tensp }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Giá</label>
                            <input type="number" name="gia" class="form-control"
                                   value="{{ $product->gia }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Xuất xứ</label>
                            <input type="text" name="xuatxu" class="form-control"
                                   value="{{ $product->xuatxu }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Kiểu đồng hồ</label>
                            <select name="kieu" class="form-control" required>
                                <option value="Đồng hồ nam"
                                        {{ $product->kieu == 'Đồng hồ nam' ? 'selected' : '' }}>
                                    Đồng hồ nam
                                </option>
                                <option value="Đồng hồ nữ"
                                        {{ $product->kieu == 'Đồng hồ nữ' ? 'selected' : '' }}>
                                    Đồng hồ nữ
                                </option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Chất liệu vỏ</label>
                            <input type="text" name="clieuvo" class="form-control"
                                   value="{{ $product->clieuvo }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Chất liệu dây</label>
                            <input type="text" name="clieuday" class="form-control"
                                   value="{{ $product->clieuday }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Kích thước</label>
                            <input type="text" name="clieukinh" class="form-control"
                                   value="{{ $product->clieukinh }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Khả năng chống nước</label>
                            <input type="text" name="khangnuoc" class="form-control"
                                   value="{{ $product->khangnuoc }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Thời gian bảo hành (năm)</label>
                            <input type="number" name="tgbaohanh_nam" class="form-control"
                                   value="{{ $product->tgbaohanh_nam }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Số lượng trong kho</label>
                            <input type="number" name="soluong" class="form-control" min="0"
                                   value="{{ $product->chiTietKho->sum('soluong') }}" required>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="mb-3">
                            <label class="form-label">Thương hiệu</label>
                            <select name="idnhasx" class="form-control" required>
                                @foreach($manufacturers as $manufacturer)
                                    <option value="{{ $manufacturer->idnhasx }}"
                                            {{ $product->idnhasx == $manufacturer->idnhasx ? 'selected' : '' }}>
                                        {{ $manufacturer->tennhasx }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Hình ảnh hiện tại</label>
                            <div class="mb-2">
                                <img src="{{ asset($product->hinhsp) }}"
                                     alt="{{ $product->tensp }}"
                                     style="max-width: 200px;">
                            </div>
                            <input type="file" name="hinhsp" class="form-control" accept="image/*">
                            <small class="text-muted">Chỉ upload ảnh mới nếu muốn thay đổi</small>
                        </div>
                    </div>
                </div>

                <div class="text-end">
                    <a href="{{ route('admin.products') }}" class="btn btn-secondary">Hủy</a>
                    <button type="submit" class="btn btn-primary">Cập nhật</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
