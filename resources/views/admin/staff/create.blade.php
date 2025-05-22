@extends('admin.layouts.app')

@section('title', 'Thêm nhân viên mới')

@section('content')
<div class="container-fluid">
    <div class="row mb-3">
        <div class="col-md-12">
            <h1 class="h3">Thêm nhân viên mới</h1>
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
            <form action="{{ route('admin.staff.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Họ</label>
                            <input type="text" name="honv"
                                   class="form-control @error('honv') is-invalid @enderror"
                                   value="{{ old('honv') }}" required>
                            @error('honv')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Tên</label>
                            <input type="text" name="tennv"
                                   class="form-control @error('tennv') is-invalid @enderror"
                                   value="{{ old('tennv') }}" required>
                            @error('tennv')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Số điện thoại</label>
                            <input type="text" name="sdttk"
                                   class="form-control @error('sdttk') is-invalid @enderror"
                                   value="{{ old('sdttk') }}" required>
                            @error('sdttk')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email"
                                   class="form-control @error('email') is-invalid @enderror"
                                   value="{{ old('email') }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Mật khẩu</label>
                            <input type="password" name="password"
                                   class="form-control @error('password') is-invalid @enderror"
                                   required>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Địa chỉ</label>
                            <textarea name="diachinv"
                                      class="form-control @error('diachinv') is-invalid @enderror"
                                      rows="3" required>{{ old('diachinv') }}</textarea>
                            @error('diachinv')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="text-end">
                    <a href="{{ route('admin.staff') }}" class="btn btn-secondary">Hủy</a>
                    <button type="submit" class="btn btn-primary">Thêm nhân viên</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
