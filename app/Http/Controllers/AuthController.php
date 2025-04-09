<?php
namespace App\Http\Controllers;

use App\Models\TaiKhoan;
use App\Models\KhachHang;
use App\Models\NhanVien;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    // Đăng nhập
    public function showLoginForm()
    {
        return view('auth');
    }

    public function login(Request $request)
    {
        // Kiểm tra thông tin nhập vào
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

        // Tìm tài khoản trong bảng taikhoan
        $taiKhoan = TaiKhoan::where($field, $request->email_or_phone)->first();

        if ($taiKhoan && Hash::check($request->password, $taiKhoan->matkhau)) {
            // Kiểm tra nếu là nhân viên/admin
            $nhanVien = NhanVien::where('idtk', $taiKhoan->idtk)->first();
            if ($nhanVien) {
                return redirect()->route('employee.dashboard')->with('success', 'Đăng nhập thành công');
            }

            // Nếu là khách hàng
            $khachHang = KhachHang::where('idtk', $taiKhoan->idtk)->first();
            if ($khachHang) {
                Auth::login($taiKhoan);
                return redirect()->route('index')->with('success', 'Đăng nhập thành công');
            }
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
            'phone' => 'required|unique:taikhoan,sdttk|max:10',
            'add' => 'required|string|max:200',
            'full_name' => 'required|string|max:50',
            'password1' => 'required|string|min:6',
            'password2' => 'required|same:password1'
        ]);

        if ($validator->fails()) {
            return redirect()->route('auth')
                ->withErrors($validator)
                ->withInput();
        }

        // Tạo tài khoản mới
        $taiKhoan = TaiKhoan::create([
            'emailtk' => $request->email,
            'sdttk' => $request->phone,
            'matkhau' => Hash::make($request->password1),
        ]);

       // Tạo khách hàng
        $nameParts = explode(" ", $request->full_name);
        $lastName = array_pop($nameParts); // Get last part as the name
        $firstName = implode(" ", $nameParts); // Join remaining parts as the ho

        $khachHang = KhachHang::create([
            'tenkh' => $lastName,
            'hokh' => $firstName,
            'diachikh' => $request->add,
            'idtk' => $taiKhoan->idtk
        ]);

        return redirect()->route('auth')->with('success', 'Đăng ký thành công, vui lòng đăng nhập');
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('index');
    }
}
