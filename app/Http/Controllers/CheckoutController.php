<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GioHang;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\DonHang;

class CheckoutController extends Controller
{
    private function calculateShipping($subtotal)
    {
        if ($subtotal < 5000000) {
            return 0; // Miễn phí
        } elseif ($subtotal <= 20000000) {
            return 500000; // 500k
        } else {
            return 1000000; // 1 triệu
        }
    }

    public function index()
    {
        if (!Auth::check()) {
            return redirect()->route('auth');
        }

        $user = Auth::user();
        $customer = $user->khachHang;
        $cart = GioHang::where('idkh', $customer->idkh)->first();

        if (!$cart || $cart->chiTietGioHang->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Giỏ hàng trống');
        }

        $items = [];
        $subtotal = 0;

        foreach ($cart->chiTietGioHang as $item) {
            $product = $item->sanPham;
            $total = $product->gia * $item->soluong;
            $subtotal += $total;

            $items[] = [
                'tensp' => $product->tensp,
                'hinhsp' => $product->hinhsp,
                'gia' => $product->gia,
                'soluong' => $item->soluong,
                'total' => $total
            ];
        }

        // Tính phí vận chuyển dựa trên tổng giá trị đơn hàng
        $shipping = $this->calculateShipping($subtotal);
        $grandTotal = $subtotal + $shipping;

        return view('checkout.index', compact(
            'customer',
            'items',
            'subtotal',
            'shipping',
            'grandTotal'
        ));
    }

    public function process(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('auth');
        }

        try {
            DB::beginTransaction();

            $customer = Auth::user()->khachHang;
            $cart = GioHang::where('idkh', $customer->idkh)->first();

            if (!$cart || $cart->chiTietGioHang->isEmpty()) {
                throw new \Exception('Giỏ hàng trống');
            }

            // Tính tổng tiền và phí vận chuyển
            $subtotal = 0;
            foreach ($cart->chiTietGioHang as $item) {
                $subtotal += $item->sanPham->gia * $item->soluong;
            }

            $shipping = $this->calculateShipping($subtotal);
            $total = $subtotal + $shipping;

            // Tạo đơn hàng
            $order = DonHang::create([
                'iddhang' => Str::uuid(),
                'idkh' => $customer->idkh,
                'tongtien' => $total,
                'phivanchuyen' => $shipping,
                'trangthai' => 'Chờ xác nhận'
            ]);

            // Chuyển sản phẩm từ giỏ hàng sang chi tiết đơn hàng
            foreach ($cart->chiTietGioHang as $item) {
                $dongia = $item->sanPham->gia;
                $thanhtien = $dongia * $item->soluong;

                DB::table('chitietdonhang')->insert([
                    'iddhang' => $order->iddhang,
                    'idsp' => $item->idsp,
                    'soluong' => $item->soluong,
                    'dongia' => $dongia,
                    'giamgia' => 0,
                    'thanhtien' => $thanhtien,
                    'ghichu' => null
                ]);
            }

            // Xóa giỏ hàng
            $cart->chiTietGioHang()->delete();
            $cart->delete();

            DB::commit();

            return redirect()->route('orders.history')
                ->with('success', 'Đặt hàng thành công! Mã đơn hàng: ' . $order->iddhang);

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }
}
