<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TaiKhoan;
use App\Models\NhanVien;
use App\Models\QuyenHan;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class AdminStaffSeeder extends Seeder
{
    public function run()
    {
        // Tạo tài khoản admin
        $adminAccount = TaiKhoan::create([
            'emailtk' => 'admin@watchstore.com',
            'sdttk' => '0123456789',
            'matkhau' => Hash::make('admin123'),
            'trangthai' => 1
        ]);

        NhanVien::create([
            'tennv' => 'Admin',
            'honv' => 'Super',
            'diachinv' => 'Watch Store HQ',
            'idtk' => $adminAccount->idtk
        ]);

        // Phân quyền admin
        DB::table('phanquyen')->insert([
            'idtk' => $adminAccount->idtk,
            'idqh' => 1 // admin
        ]);

        // Tạo tài khoản nhân viên
        $staffAccount = TaiKhoan::create([
            'emailtk' => 'staff@watchstore.com',
            'sdttk' => '0987654321',
            'matkhau' => Hash::make('staff123'),
            'trangthai' => 1
        ]);

        NhanVien::create([
            'tennv' => 'Staff',
            'honv' => 'Watch Store',
            'diachinv' => 'Watch Store Branch',
            'idtk' => $staffAccount->idtk
        ]);

        // Phân quyền nhân viên
        DB::table('phanquyen')->insert([
            'idtk' => $staffAccount->idtk,
            'idqh' => 2 // staff
        ]);
    }
}
