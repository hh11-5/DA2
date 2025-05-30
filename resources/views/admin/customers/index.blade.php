@extends('admin.layouts.app')

@section('title', 'Quản lý khách hàng')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Danh sách khách hàng</h3>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="close" data-dismiss="alert">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Họ và tên</th>
                            <th>Email</th>
                            <th>Số điện thoại</th>
                            <th>Địa chỉ</th>
                            <th>Trạng thái</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($customers as $customer)
                        <tr>
                            <td>{{ $customer->idkh }}</td>
                            <td>{{ $customer->hokh }} {{ $customer->tenkh }}</td>
                            <td>{{ $customer->taiKhoan->emailtk }}</td>
                            <td>{{ $customer->taiKhoan->sdttk }}</td>
                            <td>{{ $customer->diachikh }}</td>
                            <td>
                                <span class="badge bg-{{ $customer->taiKhoan->trangthai ? 'success' : 'danger' }}">
                                    {{ $customer->taiKhoan->trangthai ? 'Hoạt động' : 'Đã khóa' }}
                                </span>
                            </td>
                            <td>
                                <form action="{{ route('admin.customers.toggle', $customer->idkh) }}"
                                      method="POST"
                                      class="d-inline">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit"
                                            class="btn btn-sm {{ $customer->taiKhoan->trangthai ? 'btn-warning' : 'btn-success' }}"
                                            title="{{ $customer->taiKhoan->trangthai ? 'Khóa tài khoản' : 'Mở khóa' }}">
                                        <i class="fas fa-{{ $customer->taiKhoan->trangthai ? 'lock' : 'unlock' }}"></i>
                                    </button>
                                </form>

                                <form action="{{ route('admin.customers.delete', $customer->idkh) }}"
                                      method="POST"
                                      class="d-inline"
                                      onsubmit="return confirm('Bạn có chắc muốn xóa khách hàng này?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" title="Xóa">
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
                {{ $customers->links() }}
            </div>
        </div>
    </div>
</div>

<style>
.badge {
    padding: 8px 12px;
    font-weight: 500;
}

.btn-sm {
    padding: 0.25rem 0.5rem;
    margin: 0 0.1rem;
}
</style>
@endsection
