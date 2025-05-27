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
use Illuminate\Support\Facades\Hash;
use App\Models\ChiTietKho;
use App\Models\ChiTietDonHang;
use Carbon\Carbon;

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
        if ($response = $this->checkAdminAccess()) {
            return $response;
        }

        // Lấy số lượng sản phẩm đã bán và doanh thu hôm nay
        $today = Carbon::today();
        $todayProducts = ChiTietDonHang::whereHas('donHang', function($query) use ($today) {
            $query->where('trangthai', 3)
                  ->whereDate('ngaydathang', $today);
        })->sum('soluong');

        $todayRevenue = ChiTietDonHang::whereHas('donHang', function($query) use ($today) {
            $query->where('trangthai', 3)
                  ->whereDate('ngaydathang', $today);
        })->sum(DB::raw('soluong * dongia'));

        // Lấy thống kê top 10 sản phẩm bán chạy
        $products = ChiTietDonHang::with('sanPham')
            ->select(
                'idsp',
                DB::raw('SUM(soluong) as total_quantity'),
                DB::raw('SUM(thanhtien) as total_revenue')
            )
            ->whereHas('donHang', function($query) {
                $query->where('trangthai', 3); // Chỉ lấy đơn hàng đã hoàn thành
            })
            ->groupBy('idsp')
            ->orderBy('total_quantity', 'desc')
            ->limit(10)
            ->get()
            ->map(function($item) {
                return [
                    'tensp' => $item->sanPham->tensp,
                    'total_quantity' => $item->total_quantity,
                    'total_revenue' => $item->total_revenue
                ];
            });

        return view('admin.dashboard', compact('todayProducts', 'todayRevenue', 'products'));
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

        $query = SanPham::with(['nhasanxuat', 'chiTietKho']);

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

        $products = $query->paginate(50)->withQueryString();
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

            // Tạo sản phẩm mới
            $product = SanPham::create($validated);

            // Tạo chi tiết kho cho sản phẩm
            ChiTietKho::create([
                'idkho' => 1, // ID của kho chính
                'idsp' => $product->idsp,
                'soluong' => $request->soluong,
            ]);

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

            // Cập nhật thông tin sản phẩm
            $product->update($validated);

            // Cập nhật số lượng trong kho
            $chiTietKho = ChiTietKho::where('idsp', $id)->first();
            if ($chiTietKho) {
                $chiTietKho->soluong = $request->soluong;
                $chiTietKho->save();
            } else {
                ChiTietKho::create([
                    'idkho' => 1,
                    'idsp' => $id,
                    'soluong' => $request->soluong,
                ]);
            }

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

        \Log::info('Start staff creation with data:', $request->all());

        try {
            $validated = $request->validate([
                'honv' => 'required|string|max:50',
                'tennv' => 'required|string|max:50',
                'diachinv' => 'required|string',
                'email' => 'required|email|unique:taikhoan,emailtk',
                'password' => 'required|min:6',
                'sdttk' => [
                    'required',
                    'string',
                    'unique:taikhoan,sdttk',
                    'regex:/^0[3|5|7|8|9][0-9]{8}$/'
                ]
            ]);

            \Log::info('Validation passed');

            DB::beginTransaction();

            // 1. Tạo tài khoản
            $taiKhoan = TaiKhoan::create([
                'emailtk' => $validated['email'],
                'sdttk' => $validated['sdttk'],
                'matkhau' => Hash::make($validated['password']),
                'trangthai' => 1
            ]);

            \Log::info('Account created:', ['id' => $taiKhoan->idtk]);

            // 2. Tạo nhân viên
            $nhanVien = NhanVien::create([
                'honv' => $validated['honv'],
                'tennv' => $validated['tennv'],
                'diachinv' => $validated['diachinv'],
                'idtk' => $taiKhoan->idtk
            ]);

            \Log::info('Employee created:', ['id' => $nhanVien->idnv]);

            // 3. Tạo phân quyền
            $phanQuyen = DB::table('phanquyen')->insert([
                'idtk' => $taiKhoan->idtk,
                'idqh' => 2 // staff role
            ]);

            \Log::info('Permission created');

            DB::commit();
            \Log::info('Transaction committed successfully');

            return redirect()->route('admin.staff')
                ->with('success', 'Thêm nhân viên thành công');

        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error('Validation error:', ['errors' => $e->errors()]);
            return back()
                ->withErrors($e->errors())
                ->withInput();
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Staff creation error:', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return back()
                ->with('error', 'Có lỗi xảy ra: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function toggleStaffStatus($id)
    {
        if ($response = $this->checkAdminAccess()) {
            return $response;
        }

        try {
            $nhanVien = NhanVien::findOrFail($id);

            // Kiểm tra có phải super admin không
            if ($nhanVien->taiKhoan->emailtk === 'admin@watchstore.com') {
                return back()->with('error', 'Không thể vô hiệu hóa tài khoản Super Admin');
            }

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
            $nhanVien = NhanVien::findOrFail($id);

            // Kiểm tra có phải super admin không
            if ($nhanVien->taiKhoan->emailtk === 'admin@watchstore.com') {
                return back()->with('error', 'Không thể xóa tài khoản Super Admin');
            }

            DB::beginTransaction();

            // Xóa các bản ghi liên quan
            PhanQuyen::where('idtk', $nhanVien->taiKhoan->idtk)->delete();
            $nhanVien->delete();
            $nhanVien->taiKhoan->delete();

            DB::commit();
            return redirect()->route('admin.staff')
                ->with('success', 'Xóa nhân viên thành công');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }

    /**
     * Hiển thị danh sách thương hiệu
     */
    public function brands()
    {
        if ($response = $this->checkAdminAccess()) {
            return $response;
        }

        $brands = NhaSanXuat::withCount('sanPhams')->get();
        return view('admin.brands.index', compact('brands'));
    }

    /**
     * Lưu thương hiệu mới
     */
    public function storeBrand(Request $request)
    {
        if ($response = $this->checkAdminAccess()) {
            return $response;
        }

        $validated = $request->validate([
            'tennhasx' => 'required|max:50|unique:nhasanxuat',
            'diachi' => 'nullable|string',
            'sdt' => 'nullable|string|max:15',
            'email' => 'nullable|email|max:50'
        ]);

        NhaSanXuat::create($validated);
        return redirect()->route('admin.brands')->with('success', 'Thêm thương hiệu thành công');
    }

    /**
     * Cập nhật thông tin thương hiệu
     */
    public function updateBrand(Request $request, $id)
    {
        if ($response = $this->checkAdminAccess()) {
            return $response;
        }

        $validated = $request->validate([
            'tennhasx' => 'required|max:50|unique:nhasanxuat,tennhasx,'.$id.',idnhasx',
            'diachi' => 'nullable|string',
            'sdt' => 'nullable|string|max:15',
            'email' => 'nullable|email|max:50'
        ]);

        $brand = NhaSanXuat::findOrFail($id);
        $brand->update($validated);

        return redirect()->route('admin.brands')
            ->with('success', 'Cập nhật thương hiệu thành công');
    }

    /**
     * Xóa thương hiệu
     */
    public function deleteBrand($id)
    {
        if ($response = $this->checkAdminAccess()) {
            return $response;
        }

        $brand = NhaSanXuat::withCount('sanPhams')->findOrFail($id);

        if ($brand->san_phams_count > 0) {
            return back()->with('error', 'Không thể xóa thương hiệu đã có sản phẩm');
        }

        $brand->delete();
        return redirect()->route('admin.brands')
            ->with('success', 'Xóa thương hiệu thành công');
    }
}
