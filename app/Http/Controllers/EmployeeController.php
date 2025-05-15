<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\DonHang;
use App\Models\ChiTietDonHang;

class EmployeeController extends Controller
{
    private function checkEmployeeAccess()
    {
        if (!Auth::check()) {
            return redirect()->route('admin.loginForm')
                ->with('error', 'Vui lòng đăng nhập để tiếp tục');
        }

        if (!Auth::user()->nhanVien || Auth::user()->phanQuyen->idqh != 2) {
            return redirect()->route('index')
                ->with('error', 'Bạn không có quyền truy cập trang này');
        }

        return null;
    }

    public function dashboard()
    {
        if ($response = $this->checkEmployeeAccess()) {
            return $response;
        }

        return view('admin.dashboard'); // Tạm thời dùng chung view với admin
    }

    public function orders()
    {
        if ($response = $this->checkEmployeeAccess()) {
            return $response;
        }

        $orders = DonHang::with(['khachHang', 'chiTietDonHang'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('employee.orders.index', compact('orders'));
    }

    public function showOrder($iddhang)
    {
        if ($response = $this->checkEmployeeAccess()) {
            return $response;
        }

        $order = DonHang::with(['khachHang', 'chiTietDonHang.sanPham'])
            ->findOrFail($iddhang);

        return view('employee.orders.show', compact('order'));
    }

    public function updateOrderStatus(Request $request, $iddhang)
    {
        if ($response = $this->checkEmployeeAccess()) {
            return $response;
        }

        $request->validate([
            'trangthai' => 'required|in:0,1,2,3,4'
            // 0: Đang xử lý, 1: Đã xác nhận, 2: Đang giao, 3: Đã giao, 4: Đã hủy
        ]);

        try {
            $order = DonHang::findOrFail($iddhang);
            $order->trangthai = $request->trangthai;
            $order->save();

            return redirect()->route('employee.orders')
                ->with('success', 'Cập nhật trạng thái đơn hàng thành công');
        } catch (\Exception $e) {
            return back()->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }
}
