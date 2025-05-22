@extends('admin.layouts.app')

@section('title', 'Quản lý nhân viên')

@section('content')
<div class="container-fluid">
    <div class="row mb-3">
        <div class="col-12 d-flex justify-content-between align-items-center">
            <h1 class="h3 mb-0">Quản lý nhân viên</h1>
            <a href="{{ route('admin.staff.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i>Thêm nhân viên mới
            </a>
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
                            <th>Mã NV</th>
                            <th>Họ và tên</th>
                            <th>Email</th>
                            <th>Số điện thoại</th>
                            <th>Địa chỉ</th>
                            <th>Trạng thái</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($staff as $employee)
                        <tr>
                            <td>{{ $employee->idnv }}</td>
                            <td>{{ $employee->honv }} {{ $employee->tennv }}</td>
                            <td>{{ $employee->taiKhoan->emailtk }}</td>
                            <td>{{ $employee->taikhoan->sdttk }}</td>
                            <td>{{ $employee->diachinv }}</td>
                            <td>
                                @if($employee->taiKhoan->emailtk === 'admin@watchstore.com')
                                    <!-- Super admin luôn active và không thể thay đổi -->
                                    <span class="badge bg-success">Hoạt động</span>
                                @else
                                    <span class="badge bg-{{ $employee->taiKhoan->trangthai ? 'success' : 'danger' }}">
                                        {{ $employee->taiKhoan->trangthai ? 'Hoạt động' : 'Vô hiệu hóa' }}
                                    </span>
                                @endif
                            </td>
                            <td>
                                @if($employee->taiKhoan->emailtk === 'admin@watchstore.com')
                                    <!-- Super admin không có nút vô hiệu hóa và xóa -->
                                    <span class="text-muted"><i class="fas fa-lock"></i> Super Admin</span>
                                @else
                                    <form action="{{ route('admin.staff.toggle-status', $employee->idnv) }}"
                                          method="POST"
                                          class="d-inline">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit"
                                                class="btn btn-sm {{ $employee->taiKhoan->trangthai ? 'btn-warning' : 'btn-success' }}"
                                                title="{{ $employee->taiKhoan->trangthai ? 'Vô hiệu hóa' : 'Kích hoạt' }}">
                                            <i class="fas fa-{{ $employee->taiKhoan->trangthai ? 'ban' : 'check' }}"></i>
                                        </button>
                                    </form>

                                    <form action="{{ route('admin.staff.delete', $employee->idnv) }}"
                                          method="POST"
                                          class="d-inline"
                                          onsubmit="return confirm('Bạn có chắc muốn xóa nhân viên này?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" title="Xóa">
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

            <div class="mt-3">
                {{ $staff->links() }}
            </div>
        </div>
    </div>
</div>
@endsection

<style>
.badge {
    padding: 8px 12px;
    font-weight: 500;
}

.bg-success {
    background-color: #198754 !important;
}

.bg-danger {
    background-color: #dc3545 !important;
}

.btn-warning {
    color: #000;
    background-color: #ffc107;
    border-color: #ffc107;
}

.btn-success {
    color: #fff;
    background-color: #198754;
    border-color: #198754;
}
</style>
