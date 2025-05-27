<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DonHang;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class OrderController extends Controller
{
    public function history(Request $request)
    {
        $user = auth()->user();
        $query = DonHang::where('idkh', $user->khachHang->idkh);

        // Lọc theo trạng thái
        if ($request->has('status')) {
            $query->where('trangthai', $request->status);
        }

        // Lấy số lượng đơn hàng cho từng trạng thái
        $pendingCount = DonHang::where('idkh', $user->khachHang->idkh)
                              ->where('trangthai', 0)->count();
        $shippingCount = DonHang::where('idkh', $user->khachHang->idkh)
                             ->where('trangthai', 1)->count();
        $deliveringCount = DonHang::where('idkh', $user->khachHang->idkh)
                               ->where('trangthai', 2)->count();

        $orders = $query->orderBy('ngaydathang', 'desc')->paginate(10);

        return view('history', compact('orders', 'pendingCount',
            'shippingCount', 'deliveringCount'));
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

    public function cancel($id)
    {
        $order = DonHang::findOrFail($id);

        if ($order->trangthai == 0 || $order->trangthai == 1) {
            $order->trangthai = 4; // Trạng thái đã hủy
            $order->save();

            return redirect()->back()->with('success', 'Đơn hàng đã được hủy thành công');
        }

        return redirect()->back()->with('error', 'Không thể hủy đơn hàng này');
    }

    public function index()
    {
        $orders = DonHang::where('idkh', Auth::user()->khachHang->idkh)
            ->orderBy('ngaydathang', 'desc')
            ->get();

        // Đếm số lượng đơn theo trạng thái
        $pendingCount = $orders->where('trangthai', 0)->count();
        $shippingCount = $orders->where('trangthai', 1)->count();
        $deliveringCount = $orders->where('trangthai', 2)->count();

        return view('history', compact('orders', 'pendingCount', 'shippingCount', 'deliveringCount'));
    }
}
