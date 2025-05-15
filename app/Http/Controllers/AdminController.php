<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\PhanQuyen;
use App\Models\SanPham;
use App\Models\NhaSanXuat;
use Illuminate\Support\Facades\DB;
use App\Models\TaiKhoan;
use App\Models\NhanVien;

class AdminController extends Controller
{
    private function checkAdminAccess()
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

        // Kiểm tra có phải admin không
        $phanQuyen = Auth::user()->phanQuyen;
        if (!$phanQuyen || $phanQuyen->idqh != 1) { // 1 là ID quyền admin
            return redirect()->route('index')
                ->with('error', 'Bạn không có quyền truy cập trang này');
        }

        return null;
    }

    public function dashboard()
    {
        // Kiểm tra quyền
        if ($response = $this->checkAdminAccess()) {
            return $response;
        }

        return view('admin.dashboard');
    }

    // Thêm logic kiểm tra vào tất cả các methods khác
    public function revenue()
    {
        if ($response = $this->checkAdminAccess()) {
            return $response;
        }
        // Logic xử lý revenue
    }

    public function products(Request $request)
    {
        if ($response = $this->checkAdminAccess()) {
            return $response;
        }

        $query = SanPham::with('nhasanxuat');

        // Apply filters
        if ($request->filled('masp')) {
            $query->where('masp', 'like', '%' . $request->masp . '%');
        }

        if ($request->filled('tensp')) {
            $query->where('tensp', 'like', '%' . $request->tensp . '%');
        }

        if ($request->filled('gia_min')) {
            $query->where('gia', '>=', $request->gia_min);
        }

        if ($request->filled('gia_max')) {
            $query->where('gia', '<=', $request->gia_max);
        }

        if ($request->filled('idnhasx')) {
            $query->where('idnhasx', $request->idnhasx);
        }

        $products = $query->paginate(10)->withQueryString();
        $manufacturers = NhaSanXuat::all();

        return view('admin.products.index', compact('products', 'manufacturers'));
    }

    public function createProduct()
    {
        if ($response = $this->checkAdminAccess()) {
            return $response;
        }

        $manufacturers = NhaSanXuat::all();
        return view('admin.products.create', compact('manufacturers'));
    }

    public function storeProduct(Request $request)
    {
        if ($response = $this->checkAdminAccess()) {
            return $response;
        }

        $validated = $request->validate([
            'masp' => 'required|unique:sanpham',
            'tensp' => 'required',
            'gia' => 'required|numeric|min:0',
            'xuatxu' => 'required',
            'kieu' => 'required',
            'clieuvo' => 'required',
            'clieuday' => 'required',
            'clieukinh' => 'required',
            'khangnuoc' => 'required',
            'tgbaohanh_nam' => 'required|numeric|min:0',
            'idnhasx' => 'required|exists:nhasanxuat,idnhasx',
            'hinhsp' => 'required|image|max:2048'
        ]);

        try {
            DB::beginTransaction();

            // Handle file upload
            if ($request->hasFile('hinhsp')) {
                $image = $request->file('hinhsp');
                $filename = time() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('images/products'), $filename);
                $validated['hinhsp'] = 'images/products/' . $filename;
            }

            SanPham::create($validated);

            DB::commit();
            return redirect()->route('admin.products')
                ->with('success', 'Thêm sản phẩm thành công');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }

    public function editProduct($id)
    {
        if ($response = $this->checkAdminAccess()) {
            return $response;
        }

        $product = SanPham::findOrFail($id);
        $manufacturers = NhaSanXuat::all();
        return view('admin.products.edit', compact('product', 'manufacturers'));
    }

    public function updateProduct(Request $request, $id)
    {
        if ($response = $this->checkAdminAccess()) {
            return $response;
        }

        $product = SanPham::findOrFail($id);

        $validated = $request->validate([
            'masp' => 'required|unique:sanpham,masp,'.$id.',idsp',
            'tensp' => 'required',
            'gia' => 'required|numeric|min:0',
            'xuatxu' => 'required',
            'kieu' => 'required',
            'clieuvo' => 'required',
            'clieuday' => 'required',
            'clieukinh' => 'required',
            'khangnuoc' => 'required',
            'tgbaohanh_nam' => 'required|numeric|min:0',
            'idnhasx' => 'required|exists:nhasanxuat,idnhasx',
            'hinhsp' => 'nullable|image|max:2048'
        ]);

        try {
            DB::beginTransaction();

            if ($request->hasFile('hinhsp')) {
                // Delete old image
                if ($product->hinhsp && file_exists(public_path($product->hinhsp))) {
                    unlink(public_path($product->hinhsp));
                }

                // Upload new image
                $image = $request->file('hinhsp');
                $filename = time() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('images/products'), $filename);
                $validated['hinhsp'] = 'images/products/' . $filename;
            }

            $product->update($validated);

            DB::commit();
            return redirect()->route('admin.products')
                ->with('success', 'Cập nhật sản phẩm thành công');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }

    public function deleteProduct($id)
    {
        if ($response = $this->checkAdminAccess()) {
            return $response;
        }

        try {
            DB::beginTransaction();

            $product = SanPham::findOrFail($id);

            // Delete image file
            if ($product->hinhsp && file_exists(public_path($product->hinhsp))) {
                unlink(public_path($product->hinhsp));
            }

            $product->delete();

            DB::commit();
            return redirect()->route('admin.products')
                ->with('success', 'Xóa sản phẩm thành công');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }

    public function staff()
    {
        if ($response = $this->checkAdminAccess()) {
            return $response;
        }

        $staff = NhanVien::with(['taiKhoan', 'taiKhoan.phanQuyen'])->paginate(10);
        return view('admin.staff.index', compact('staff'));
    }

    public function createStaff()
    {
        if ($response = $this->checkAdminAccess()) {
            return $response;
        }

        return view('admin.staff.create');
    }

    public function storeStaff(Request $request)
    {
        if ($response = $this->checkAdminAccess()) {
            return $response;
        }

        $validated = $request->validate([
            'honv' => 'required|string|max:50',
            'tennv' => 'required|string|max:50',
            'sdtnv' => 'required|string|unique:nhanvien,sdtnv',
            'diachinv' => 'required|string',
            'email' => 'required|email|unique:taikhoan,emailtk',
            'password' => 'required|min:6',
        ]);

        try {
            DB::beginTransaction();

            // Create account
            $taiKhoan = TaiKhoan::create([
                'emailtk' => $validated['email'],
                'matkhau' => bcrypt($validated['password']),
                'sdttk' => $validated['sdtnv'],
                'trangthai' => 1
            ]);

            // Create employee record
            $nhanVien = NhanVien::create([
                'honv' => $validated['honv'],
                'tennv' => $validated['tennv'],
                'sdtnv' => $validated['sdtnv'],
                'diachinv' => $validated['diachinv'],
                'idtk' => $taiKhoan->idtk
            ]);

            // Create permission (2 for employee role)
            PhanQuyen::create([
                'idtk' => $taiKhoan->idtk,
                'idqh' => 2
            ]);

            DB::commit();
            return redirect()->route('admin.staff')
                ->with('success', 'Thêm nhân viên thành công');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }

    public function toggleStaffStatus($id)
    {
        if ($response = $this->checkAdminAccess()) {
            return $response;
        }

        try {
            $nhanVien = NhanVien::findOrFail($id);
            $taiKhoan = $nhanVien->taiKhoan;

            $taiKhoan->trangthai = !$taiKhoan->trangthai;
            $taiKhoan->save();

            return redirect()->route('admin.staff')
                ->with('success', 'Cập nhật trạng thái nhân viên thành công');

        } catch (\Exception $e) {
            return back()->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }

    public function deleteStaff($id)
    {
        if ($response = $this->checkAdminAccess()) {
            return $response;
        }

        try {
            DB::beginTransaction();

            $nhanVien = NhanVien::findOrFail($id);
            $taiKhoan = $nhanVien->taiKhoan;

            // Delete related records
            PhanQuyen::where('idtk', $taiKhoan->idtk)->delete();
            $nhanVien->delete();
            $taiKhoan->delete();

            DB::commit();
            return redirect()->route('admin.staff')
                ->with('success', 'Xóa nhân viên thành công');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }
}
