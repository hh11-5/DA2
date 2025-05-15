<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use App\Rules\VietnamesePhone;

class ProfileController extends Controller
{
    public function index()
    {
        if (!Auth::check()) {
            return redirect()->route('auth')
                ->with('error', 'Vui lòng đăng nhập để xem thông tin tài khoản');
        }

        $user = Auth::user();
        $customer = $user->khachHang;
        return view('profile', compact('user', 'customer'));
    }

    private function validateAddress($address)
    {
        try {
            $response = Http::withHeaders([
                'User-Agent' => 'WatchStore/1.0'
            ])->get('https://nominatim.openstreetmap.org/search', [
                'q' => $address . ', Việt Nam',
                'format' => 'json',
                'addressdetails' => 1,
                'limit' => 1,
                'countrycodes' => 'vn'
            ]);

            if (!$response->successful()) {
                \Log::error('Nominatim API error:', [
                    'status' => $response->status(),
                    'body' => $response->body()
                ]);
                return false;
            }

            $result = $response->json();

            \Log::info('Nominatim validation response:', [
                'address' => $address,
                'result' => $result
            ]);

            // Sử dụng cùng logic với route verify-address
            if (!empty($result) && isset($result[0])) {
                $addressData = $result[0];

                if (isset($addressData['address']) &&
                    (isset($addressData['address']['country_code']) &&
                     $addressData['address']['country_code'] === 'vn')) {
                    return true;
                }
            }

            return false;
        } catch (\Exception $e) {
            \Log::error('Address validation error:', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return false;
        }
    }

    public function update(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('auth')
                ->with('error', 'Vui lòng đăng nhập để cập nhật thông tin');
        }

        $request->validate([
            'hokh' => 'required|string|max:20',
            'tenkh' => 'required|string|max:30',
            'diachikh' => 'required|string|max:100',
            'email' => 'required|email|unique:taikhoan,emailtk,' . Auth::id() . ',idtk',
            'phone' => ['required', new VietnamesePhone, 'unique:taikhoan,sdttk,' . Auth::id() . ',idtk'],
            'current_password' => 'nullable|required_with:new_password',
            'new_password' => 'nullable|min:6|same:password_confirmation'
        ], [
            'phone.required' => 'Vui lòng nhập số điện thoại',
            'phone.unique' => 'Số điện thoại đã được sử dụng'
        ]);

        try {
            // Kiểm tra địa chỉ nếu có thay đổi
            $user = Auth::user();
            $customer = $user->khachHang;

            if ($request->diachikh !== $customer->diachikh) {
                if (!$this->validateAddress($request->diachikh)) {
                    return back()
                        ->withErrors(['diachikh' => 'Địa chỉ không hợp lệ hoặc không tìm thấy'])
                        ->withInput();
                }
            }

            // Cập nhật thông tin khách hàng
            $customer->update([
                'hokh' => $request->hokh,
                'tenkh' => $request->tenkh,
                'diachikh' => $request->diachikh
            ]);

            // Cập nhật thông tin tài khoản
            $user->emailtk = $request->email;
            $user->sdttk = $request->phone;

            // Kiểm tra và cập nhật mật khẩu nếu có
            if ($request->filled('current_password')) {
                if (!Hash::check($request->current_password, $user->matkhau)) {
                    return back()
                        ->withErrors(['current_password' => 'Mật khẩu hiện tại không đúng'])
                        ->withInput();
                }
                $user->matkhau = Hash::make($request->new_password);
            }

            $user->save();

            return back()->with('success', 'Cập nhật thông tin thành công!');

        } catch (\Exception $e) {
            return back()
                ->with('error', 'Có lỗi xảy ra khi cập nhật thông tin')
                ->withInput();
        }
    }
}
