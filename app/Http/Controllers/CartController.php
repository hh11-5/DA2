<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        // Kiểm tra đăng nhập
        if (!Auth::check()) {
            return redirect()->route('auth')
                ->with('error', 'Vui lòng đăng nhập để xem giỏ hàng');
        }

        // Kiểm tra nếu là nhân viên
        if (Auth::user()->nhanVien) {
            Auth::logout();
            return redirect()->route('auth')
                ->with('error', 'Tài khoản nhân viên không thể truy cập giỏ hàng');
        }

        $cart = session()->get('cart', []);
        return view('cart.index', compact('cart'));
    }

    public function add(Request $request, $id)
    {
        if (!Auth::check()) {
            return redirect()->route('auth')
                ->with('error', 'Vui lòng đăng nhập để thêm vào giỏ hàng');
        }

        if (Auth::user()->nhanVien) {
            return redirect()->back()
                ->with('error', 'Tài khoản nhân viên không thể thêm vào giỏ hàng');
        }

        $product = Product::findOrFail($id);
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            $cart[$id]['quantity']++;
        } else {
            $cart[$id] = [
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => 1
            ];
        }

        session()->put('cart', $cart);
        return redirect()->route('cart.index')
            ->with('success', 'Đã thêm sản phẩm vào giỏ hàng!');
    }

    public function update(Request $request, $id)
    {
        if (!Auth::check()) {
            return redirect()->route('auth')
                ->with('error', 'Vui lòng đăng nhập để cập nhật giỏ hàng');
        }

        if (Auth::user()->nhanVien) {
            return redirect()->back()
                ->with('error', 'Tài khoản nhân viên không thể cập nhật giỏ hàng');
        }

        $cart = session()->get('cart', []);
        if (isset($cart[$id])) {
            $cart[$id]['quantity'] = $request->quantity;
            session()->put('cart', $cart);
        }

        return redirect()->route('cart.index')
            ->with('success', 'Cập nhật số lượng thành công!');
    }

    public function remove($id)
    {
        if (!Auth::check()) {
            return redirect()->route('auth')
                ->with('error', 'Vui lòng đăng nhập để xóa sản phẩm khỏi giỏ hàng');
        }

        if (Auth::user()->nhanVien) {
            return redirect()->back()
                ->with('error', 'Tài khoản nhân viên không thể xóa sản phẩm khỏi giỏ hàng');
        }

        $cart = session()->get('cart', []);
        unset($cart[$id]);
        session()->put('cart', $cart);
        return redirect()->route('cart.index')
            ->with('success', 'Đã xoá sản phẩm khỏi giỏ hàng.');
    }
}
