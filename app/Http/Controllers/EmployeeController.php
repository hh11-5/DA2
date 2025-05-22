<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\DonHang;

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

        // Đếm số đơn hàng đang chờ xử lý (trạng thái = 0)
        $pendingOrders = DonHang::where('trangthai', 0)->count();

        return view('admin.dashboard', compact('pendingOrders'));
    }

    public function orders(Request $request)
    {
        if ($response = $this->checkEmployeeAccess()) {
            return $response;
        }

        $query = DonHang::with(['khachHang.taiKhoan'])
            ->orderBy('ngaydathang', 'desc');

        // Lọc theo mã đơn hàng
        if ($request->filled('search')) {
            $query->where('iddhang', 'LIKE', '%' . $request->search . '%');
        }

        // Lọc theo trạng thái
        if ($request->filled('status') && $request->status !== '') {
            $query->where('trangthai', $request->status);
        }

        $orders = $query->paginate(10)->withQueryString();

        return view('employee.orders.index', compact('orders'));
    }

    public function showOrder($iddhang)
    {
        if ($response = $this->checkEmployeeAccess()) {
            return $response;
        }

        $order = DonHang::with(['khachHang.taiKhoan', 'chiTietDonHang.sanPham'])
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
        ]);

        try {
            $order = DonHang::findOrFail($iddhang);

            if ($order->trangthai == 3 || $order->trangthai == 4) {
                return back()->with('error', 'Không thể cập nhật trạng thái của đơn hàng đã hoàn thành hoặc đã hủy');
            }

            $order->trangthai = $request->trangthai;
            $order->save();

            return redirect()->route('employee.orders')
                ->with('success', 'Cập nhật trạng thái đơn hàng thành công');
        } catch (\Exception $e) {
            return back()->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }
}
