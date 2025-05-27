@extends('admin.layouts.app')

@section('title', 'Quản lý thương hiệu')

@section('content')
<div class="container-fluid">
    <div class="row mb-3">
        <div class="col-12 d-flex justify-content-between align-items-center">
            <h1 class="h3 mb-0">Quản lý thương hiệu</h1>
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addBrandModal">
                <i class="fas fa-plus me-2"></i>Thêm thương hiệu mới
            </button>
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
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Tên thương hiệu</th>
                            <th>Địa chỉ</th>
                            <th>Số điện thoại</th>
                            <th>Email</th>
                            <th>Số sản phẩm</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($brands as $brand)
                        <tr>
                            <td>{{ $brand->idnhasx }}</td>
                            <td>{{ $brand->tennhasx }}</td>
                            <td>{{ $brand->diachi }}</td>
                            <td>{{ $brand->sdt }}</td>
                            <td>{{ $brand->email }}</td>
                            <td>{{ $brand->san_phams_count }}</td>
                            <td>
                                <button class="btn btn-sm btn-info edit-brand"
                                        data-toggle="modal"
                                        data-target="#editBrandModal"
                                        data-id="{{ $brand->idnhasx }}"
                                        data-name="{{ $brand->tennhasx }}"
                                        data-address="{{ $brand->diachi }}"
                                        data-phone="{{ $brand->sdt }}"
                                        data-email="{{ $brand->email }}">
                                    <i class="fas fa-edit"></i>
                                </button>

                                @if($brand->san_phams_count == 0)
                                <form action="{{ route('admin.brands.destroy', $brand->idnhasx) }}"
                                      method="POST"
                                      class="d-inline"
                                      onsubmit="return confirm('Bạn có chắc muốn xóa thương hiệu này?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal thêm thương hiệu -->
<div class="modal fade" id="addBrandModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Thêm thương hiệu mới</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <form action="{{ route('admin.brands.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label>Tên thương hiệu</label>
                        <input type="text" name="tennhasx" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Địa chỉ</label>
                        <input type="text" name="diachi" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Số điện thoại</label>
                        <input type="text" name="sdt" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
                    <button type="submit" class="btn btn-primary">Thêm</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal sửa thương hiệu -->
<div class="modal fade" id="editBrandModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Sửa thương hiệu</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <form action="" method="POST" id="editBrandForm">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="form-group">
                        <label>Tên thương hiệu</label>
                        <input type="text" name="tennhasx" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Địa chỉ</label>
                        <input type="text" name="diachi" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Số điện thoại</label>
                        <input type="text" name="sdt" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
                    <button type="submit" class="btn btn-primary">Cập nhật</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
$('.edit-brand').click(function() {
    var id = $(this).data('id');
    var name = $(this).data('name');
    var address = $(this).data('address');
    var phone = $(this).data('phone');
    var email = $(this).data('email');

    var form = $('#editBrandForm');
    form.attr('action', '/admin/brands/' + id);
    form.find('input[name="tennhasx"]').val(name);
    form.find('input[name="diachi"]').val(address);
    form.find('input[name="sdt"]').val(phone);
    form.find('input[name="email"]').val(email);
});
</script>
@endsection
