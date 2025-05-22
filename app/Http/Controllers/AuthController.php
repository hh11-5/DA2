<?php
namespace App\Http\Controllers;

use App\Models\TaiKhoan;
use App\Models\KhachHang;
use App\Models\NhanVien;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    // Đăng nhập
    public function showLoginForm()
    {
        return view('auth');
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email_or_phone' => 'required|string',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return redirect()->route('auth')
                ->withErrors($validator)
                ->withInput();
        }

        // Kiểm tra đăng nhập bằng email hoặc số điện thoại
        $field = filter_var($request->email_or_phone, FILTER_VALIDATE_EMAIL) ? 'emailtk' : 'sdttk';
        $taiKhoan = TaiKhoan::where($field, $request->email_or_phone)->first();

        if ($taiKhoan && Hash::check($request->password, $taiKhoan->matkhau)) {
            // Kiểm tra xem có phải là khách hàng không
            $khachHang = KhachHang::where('idtk', $taiKhoan->idtk)->first();
            if ($khachHang) {
                Auth::login($taiKhoan);
                return redirect()->route('index')
                    ->with('success', 'Đăng nhập thành công');
            }

            // Nếu là nhân viên, chuyển hướng đến trang đăng nhập admin
            return redirect()->route('admin.loginForm')
                ->with('error', 'Vui lòng sử dụng trang đăng nhập dành cho nhân viên');
        }

        return redirect()->route('auth')
            ->with('error', 'Thông tin đăng nhập không chính xác')
            ->withInput();
    }

    // Đăng ký
    public function showRegisterForm()
    {
        return view('auth');  // Trả về view của form login để chuyển đổi dễ dàng
    }

    public function register(Request $request)
    {
        // Kiểm tra thông tin nhập vào
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:taikhoan,emailtk',
            'phone' => [
                'required',
                'unique:taikhoan,sdttk',
                'regex:/^0[3|5|7|8|9][0-9]{8}$/' // Kiểm tra số điện thoại VN
            ],
            'add' => 'required|string|max:200',
            'full_name' => 'required|string|max:100',
            'password1' => 'required|string|min:6',
            'password2' => 'required|same:password1'
        ], [
            'phone.regex' => 'Số điện thoại không đúng định dạng',
            'password2.same' => 'Mật khẩu nhập lại không khớp',
            'email.unique' => 'Email đã được sử dụng',
            'phone.unique' => 'Số điện thoại đã được sử dụng'
        ]);

        if ($validator->fails()) {
            return redirect()->route('auth')
                ->withErrors($validator)
                ->withInput();
        }

        try {
            DB::beginTransaction();

            // Tạo tài khoản mới với trạng thái kích hoạt
            $taiKhoan = TaiKhoan::create([
                'emailtk' => $request->email,
                'sdttk' => $request->phone,
                'matkhau' => Hash::make($request->password1),
                'trangthai' => 1 // Mặc định là kích hoạt
            ]);

            // Tách họ và tên
            $nameParts = explode(" ", trim($request->full_name));
            if (count($nameParts) < 2) {
                throw new \Exception('Họ và tên phải có ít nhất 2 từ');
            }
            $lastName = array_pop($nameParts); // Lấy tên
            $firstName = implode(" ", $nameParts); // Phần còn lại là họ

            // Tạo khách hàng
            $khachHang = KhachHang::create([
                'hokh' => $firstName,
                'tenkh' => $lastName,
                'diachikh' => $request->add,
                'idtk' => $taiKhoan->idtk
            ]);

            // Thêm phân quyền khách hàng
            DB::table('phanquyen')->insert([
                'idtk' => $taiKhoan->idtk,
                'idqh' => 3 // ID quyền hạn của khách hàng
            ]);

            DB::commit();

            return redirect()->route('auth')
                ->with('success', 'Đăng ký thành công, vui lòng đăng nhập');

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Registration Error:', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()->route('auth')
                ->with('error', 'Có lỗi xảy ra: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('index');
    }

    public function showAdminLoginForm()
    {
        return view('admin.auth');
    }

    public function adminLogin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return redirect()->route('admin.loginForm')
                ->withErrors($validator)
                ->withInput();
        }

        $taiKhoan = TaiKhoan::where('emailtk', $request->email)->first();

        if ($taiKhoan && Hash::check($request->password, $taiKhoan->matkhau)) {
            // Kiểm tra trạng thái tài khoản trước
            if (!$taiKhoan->trangthai) {
                return redirect()->route('admin.loginForm')
                    ->with('error', 'Tài khoản đã bị vô hiệu hóa');
            }

            // Kiểm tra nếu là nhân viên/admin
            $nhanVien = NhanVien::where('idtk', $taiKhoan->idtk)->first();
            if ($nhanVien) {
                // Kiểm tra quyền hạn
                $phanQuyen = DB::table('phanquyen')
                    ->where('idtk', $taiKhoan->idtk)
                    ->first();

                if ($phanQuyen) {
                    Auth::login($taiKhoan);
                    if ($phanQuyen->idqh == 1) { // Admin
                        return redirect()->route('admin.dashboard')
                            ->with('success', 'Đăng nhập thành công với tài khoản Admin');
                    } else if ($phanQuyen->idqh == 2) { // Nhân viên
                        return redirect()->route('employee.dashboard')
                            ->with('success', 'Đăng nhập thành công với tài khoản Nhân viên');
                    }
                }
            }
        }

        return redirect()->route('admin.loginForm')
            ->with('error', 'Email hoặc mật khẩu không chính xác');
    }
}
