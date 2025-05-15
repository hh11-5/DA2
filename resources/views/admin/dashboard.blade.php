<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="#">
                <img src="{{ asset('images/WebDH2.png') }}" alt="Logo" height="40">
                Admin Panel
            </a>
            <div class="ms-auto">
                <span class="text-light me-3">
                    <i class="fas fa-user me-2"></i>
                    {{ Auth::user()->nhanVien->honv }} {{ Auth::user()->nhanVien->tennv }}
                    ({{ Auth::user()->phanQuyen->idqh == 1 ? 'Admin' : 'Nhân viên' }})
                </span>
                <form action="{{ route('auth.logout') }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-outline-light btn-sm">
                        <i class="fas fa-sign-out-alt me-2"></i>Đăng xuất
                    </button>
                </form>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Dashboard</h4>
                        <p class="card-text">Đăng nhập thành công với tài khoản
                            {{ Auth::user()->phanQuyen->idqh == 1 ? 'Administrator' : 'Nhân viên' }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
