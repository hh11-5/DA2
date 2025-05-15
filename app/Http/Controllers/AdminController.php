<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\PhanQuyen;

class AdminController extends Controller
{
    public function dashboard()
    {
        // Kiểm tra đăng nhập
        if (!Auth::check()) {
            return redirect()->route('admin.loginForm')
                ->with('error', 'Vui lòng đăng nhập để tiếp tục');
        }

        // Kiểm tra quyền admin/nhân viên
        if (!Auth::user()->nhanVien) {
            return redirect()->route('index')
                ->with('error', 'Bạn không có quyền truy cập trang này');
        }

        // Nếu đã đăng nhập và có quyền, hiển thị dashboard
        return view('admin.dashboard');
    }
}
