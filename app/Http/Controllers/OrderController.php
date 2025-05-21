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
}
