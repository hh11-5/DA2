<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SanPham;
use App\Models\GioHang;
use App\Models\ChiTietGioHang;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    public function index()
    {
        if (!Auth::check()) {
            return redirect()->route('auth');
        }

        $cart = [];
        $total = 0;
        $gioHang = GioHang::where('idkh', Auth::user()->khachHang->idkh)->first();

        if ($gioHang) {
            foreach ($gioHang->chiTietGioHang as $chiTiet) {
                $sanPham = $chiTiet->sanPham;
                // Lấy số lượng tồn kho
                $tonKho = $sanPham->chiTietKho->sum('soluong') ?? 0;

                $cart[$sanPham->idsp] = [
                    'tensp' => $sanPham->tensp,
                    'hinhsp' => $sanPham->hinhsp,
                    'gia' => $sanPham->gia,
                    'quantity' => $chiTiet->soluong,
                    'tonkho' => $tonKho,
                    'ngaythem' => $chiTiet->ngaythem
                ];
                $total += $sanPham->gia * $chiTiet->soluong;
            }
        }

        return view('cart.index', compact('cart', 'total'));
    }

    public function add($id)
    {
        if (!Auth::check()) {
            return redirect()->route('auth')
                ->with('error', 'Vui lòng đăng nhập để thêm vào giỏ hàng');
        }

        try {
            DB::beginTransaction();

            $gioHang = GioHang::firstOrCreate(
                ['idkh' => Auth::user()->khachHang->idkh]
            );

            $chiTietGioHang = ChiTietGioHang::where([
                'idgh' => $gioHang->idgh,
                'idsp' => $id
            ])->first();

            if ($chiTietGioHang) {
                $chiTietGioHang->soluong += 1;
            } else {
                $chiTietGioHang = new ChiTietGioHang();
                $chiTietGioHang->idgh = $gioHang->idgh;
                $chiTietGioHang->idsp = $id;
                $chiTietGioHang->soluong = 1;
            }

            $chiTietGioHang->save();
            DB::commit();

            // Trả về response với thông tin giỏ hàng mới
            $cartInfo = $this->getCartInfo()->getData();

            return redirect()->back()
                ->with('success', 'Đã thêm sản phẩm vào giỏ hàng')
                ->with('cartInfo', $cartInfo);

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Có lỗi xảy ra khi thêm sản phẩm');
        }
    }

    public function update(Request $request, $id)
    {
        if (!Auth::check()) {
            return redirect()->route('auth')
                ->with('error', 'Vui lòng đăng nhập để cập nhật giỏ hàng');
        }

        try {
            DB::beginTransaction();

            // Lấy giỏ hàng của khách hàng
            $gioHang = GioHang::where('idkh', Auth::user()->khachHang->idkh)->first();

            if (!$gioHang) {
                throw new \Exception('Không tìm thấy giỏ hàng');
            }

            // Cập nhật chi tiết giỏ hàng bằng query builder
            $updated = DB::table('chitietgiohang')
                ->where('idgh', $gioHang->idgh)
                ->where('idsp', $id)
                ->update(['soluong' => $request->quantity]);

            if (!$updated) {
                throw new \Exception('Không tìm thấy sản phẩm trong giỏ hàng');
            }

            // Tính lại tổng tiền
            $total = DB::table('chitietgiohang')
                ->join('sanpham', 'chitietgiohang.idsp', '=', 'sanpham.idsp')
                ->where('chitietgiohang.idgh', $gioHang->idgh)
                ->sum(DB::raw('chitietgiohang.soluong * sanpham.gia'));

            DB::commit();

            return redirect()->back()
                ->with('success', 'Cập nhật số lượng thành công!')
                ->with('total', $total);

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', $e->getMessage());
        }
    }

    public function remove(Request $request, $id)
    {
        if (!Auth::check()) {
            return redirect()->back()
                ->with('error', 'Vui lòng đăng nhập để xóa sản phẩm');
        }

        try {
            $gioHang = GioHang::where('idkh', Auth::user()->khachHang->idkh)->firstOrFail();

            DB::beginTransaction();

            // Xóa chi tiết giỏ hàng
            ChiTietGioHang::where([
                'idgh' => $gioHang->idgh,
                'idsp' => $id
            ])->delete();

            // Tính lại tổng tiền giỏ hàng
            $cartTotal = DB::table('chitietgiohang')
                ->join('sanpham', 'chitietgiohang.idsp', '=', 'sanpham.idsp')
                ->where('chitietgiohang.idgh', $gioHang->idgh)
                ->sum(DB::raw('chitietgiohang.soluong * sanpham.gia'));

            DB::commit();

            // Thay vì trả về JSON response, chuyển sang redirect với flash message
            return redirect()->back()
                ->with('success', 'Đã xóa sản phẩm khỏi giỏ hàng')
                ->with('total', $cartTotal);

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Có lỗi xảy ra khi xóa sản phẩm');
        }
    }

    public function getCartInfo()
    {
        if (!Auth::check()) {
            return response()->json([
                'count' => 0,
                'total' => 0
            ]);
        }

        $gioHang = GioHang::where('idkh', Auth::user()->khachHang->idkh)->first();

        if (!$gioHang) {
            return response()->json([
                'count' => 0,
                'total' => 0
            ]);
        }

        $count = $gioHang->chiTietGioHang->count();
        $total = DB::table('chitietgiohang')
            ->join('sanpham', 'chitietgiohang.idsp', '=', 'sanpham.idsp')
            ->where('chitietgiohang.idgh', $gioHang->idgh)
            ->sum(DB::raw('chitietgiohang.soluong * sanpham.gia'));

        return response()->json([
            'count' => $count,
            'total' => $total
        ]);
    }

    /**
     * Xử lý chức năng mua ngay
     */
    public function buyNow($id)
    {
        if (!Auth::check()) {
            return redirect()->route('auth')
                ->with('error', 'Vui lòng đăng nhập để mua hàng');
        }

        if (Auth::user()->nhanVien) {
            return redirect()->back()
                ->with('error', 'Tài khoản nhân viên không thể mua hàng');
        }

        try {
            DB::beginTransaction();

            // Lấy hoặc tạo giỏ hàng
            $gioHang = GioHang::firstOrCreate(
                ['idkh' => Auth::user()->khachHang->idkh]
            );

            // Kiểm tra sản phẩm có tồn tại không
            $sanPham = SanPham::findOrFail($id);

            // Thêm hoặc cập nhật sản phẩm trong giỏ hàng
            $chiTietGioHang = ChiTietGioHang::firstOrNew([
                'idgh' => $gioHang->idgh,
                'idsp' => $id
            ]);

            if ($chiTietGioHang->exists) {
                $chiTietGioHang->soluong += 1;
            } else {
                $chiTietGioHang->soluong = 1;
                $chiTietGioHang->ngaythem = now();
            }

            $chiTietGioHang->save();

            DB::commit();

            // Chuyển hướng đến trang checkout
            return redirect()->route('checkout.index');

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Buy Now Error:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()->back()
                ->with('error', 'Có lỗi xảy ra khi xử lý đơn hàng');
        }
    }
}
