<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kho;
use App\Models\ChiTietKho;
use App\Models\SanPham;
use Carbon\Carbon;

class KhoSeeder extends Seeder
{
    public function run()
    {
        // Tạo kho mặc định theo đúng schema
        $kho = Kho::create([
            'idkho' => 1,
            'diachikho' => 'Watch Store HQ'
        ]);

        // Lấy tất cả sản phẩm
        $sanPhams = SanPham::all();

        // Thời gian hiện tại
        $now = Carbon::now();

        // Tạo chi tiết kho cho mỗi sản phẩm
        foreach ($sanPhams as $sanPham) {
            ChiTietKho::create([
                'idkho' => $kho->idkho,
                'idsp' => $sanPham->idsp,
                'soluong' => rand(5, 50), // Random số lượng từ 5-50
                'created_at' => $now,
                'updated_at' => $now
            ]);
        }
    }
}
