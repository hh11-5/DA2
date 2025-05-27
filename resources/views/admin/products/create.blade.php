@extends('admin.layouts.app')

@section('title', 'Thêm sản phẩm mới')

@section('content')
<div class="container-fluid">
    <div class="row mb-3">
        <div class="col-md-12">
            <h1 class="h3">Thêm sản phẩm mới</h1>
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
            <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Mã sản phẩm</label>
                            <input type="text" name="masp" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Tên sản phẩm</label>
                            <input type="text" name="tensp" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Giá</label>
                            <input type="number" name="gia" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Xuất xứ</label>
                            <input type="text" name="xuatxu" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Kiểu đồng hồ</label>
                            <select name="kieu" class="form-control" required>
                                <option value="Đồng hồ nam">Đồng hồ nam</option>
                                <option value="Đồng hồ nữ">Đồng hồ nữ</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Chất liệu vỏ</label>
                            <input type="text" name="clieuvo" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Chất liệu dây</label>
                            <input type="text" name="clieuday" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Kích thước</label>
                            <div class="input-group">
                                <input type="number" name="clieukinh" class="form-control" required step="0.1" min="0">
                                <span class="input-group-text">mm</span>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Khả năng chống nước</label>
                            <div class="input-group">
                                <input type="number" name="khangnuoc" class="form-control" required step="1" min="0">
                                <span class="input-group-text">m</span>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Thời gian bảo hành (năm)</label>
                            <input type="number" name="tgbaohanh_nam" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Số lượng trong kho</label>
                            <input type="number" name="soluong" class="form-control" min="0" required>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="mb-3">
                            <label class="form-label">Thương hiệu</label>
                            <select name="idnhasx" class="form-control" required>
                                @foreach($manufacturers as $manufacturer)
                                    <option value="{{ $manufacturer->idnhasx }}">
                                        {{ $manufacturer->tennhasx }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Hình ảnh</label>
                            <input type="file" name="hinhsp" class="form-control" accept="image/*" required>
                        </div>
                    </div>
                </div>

                <div class="text-end">
                    <a href="{{ route('admin.products') }}" class="btn btn-secondary">Hủy</a>
                    <button type="submit" class="btn btn-primary">Thêm sản phẩm</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
