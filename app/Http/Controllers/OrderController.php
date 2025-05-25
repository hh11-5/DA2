<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DonHang;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function history()
    {
        if (!Auth::check()) {
            return redirect()->route('auth')
                ->with('error', 'Vui lòng đăng nhập để xem lịch sử đơn hàng');
        }

        $orders = DonHang::where('idkh', Auth::user()->khachHang->idkh)
                        ->orderBy('ngaydathang', 'desc')
                        ->paginate(10);

        return view('history', compact('orders')); // Changed from orders.history to history
    }

    public function show($id)
    {
        if (!Auth::check()) {
            return redirect()->route('auth');
        }

        $order = DonHang::with(['khachHang.taiKhoan', 'chiTietDonHang.sanPham'])
            ->where('iddhang', $id)
            ->where('idkh', Auth::user()->khachHang->idkh)
            ->firstOrFail();

        return view('orders.show', compact('order'));
    }

    public function cancel(DonHang $order)
    {
        // Kiểm tra xem đơn hàng có phải của user hiện tại không
        if ($order->khachhang_id !== auth()->user()->khachHang->id) {
            return back()->with('error', 'Bạn không có quyền hủy đơn hàng này');
        }

        // Kiểm tra trạng thái đơn hàng
        if (!in_array($order->trangthai, [0, 1])) {
            return back()->with('error', 'Không thể hủy đơn hàng ở trạng thái này');
        }

        try {
            $order->update([
                'trangthai' => 4, // Trạng thái đã hủy
                'ngaycapnhat' => now()
            ]);

            return redirect()->route('orders.show', $order->iddhang)
                ->with('success', 'Đơn hàng đã được hủy thành công');
        } catch (\Exception $e) {
            return back()->with('error', 'Có lỗi xảy ra khi hủy đơn hàng');
        }
    }
}
