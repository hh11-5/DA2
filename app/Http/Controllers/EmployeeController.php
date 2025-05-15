<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmployeeController extends Controller
{
    public function dashboard()
    {
        // Kiểm tra đăng nhập
        if (!Auth::check()) {
            return redirect()->route('admin.loginForm')
                ->with('error', 'Vui lòng đăng nhập để tiếp tục');
        }

        // Kiểm tra quyền nhân viên
        if (!Auth::user()->nhanVien) {
            return redirect()->route('index')
                ->with('error', 'Bạn không có quyền truy cập trang này');
        }

        // Kiểm tra phân quyền nhân viên
        $phanQuyen = Auth::user()->phanQuyen;
        if (!$phanQuyen || $phanQuyen->idqh != 2) { // 2 là ID quyền nhân viên
            return redirect()->route('index')
                ->with('error', 'Bạn không có quyền truy cập trang này');
        }

        return view('admin.dashboard'); // Tạm thời dùng chung view với admin
    }
}
