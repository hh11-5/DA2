<?php

namespace App\Http\Controllers;

use App\Models\SanPham;
use App\Models\NhaSanXuat;

class IndexController extends Controller
{
    public function index()
    {
        $sanphams = Sanpham::orderBy('updated_at', 'desc')
                          ->take(6)
                          ->get();
        $thuonghieus = NhaSanXuat::all(); // Lấy tất cả thương hiệu

        // Giữ nguyên mảng tin tức
        $tintuc = [
            [
                'tieude' => 'Top đồng hồ hot 2025',
                'hinhanh' => './images/News1.jpg',
                'tomtat' => 'Khám phá những mẫu đồng hồ đang được ưa chuộng nhất hiện nay.',
                'link' => '#'
            ],
            [
                'tieude' => 'Đồng hồ cho doanh nhân',
                'hinhanh' => './images/News2.jpg',
                'tomtat' => 'Gợi ý mẫu đồng hồ đẳng cấp phù hợp khi đi họp, gặp đối tác.',
                'link' => '#'
            ],
            [
                'tieude' => 'Mẹo bảo quản đồng hồ',
                'hinhanh' => './images/News3.jpeg',
                'tomtat' => 'Những điều cần biết để giữ đồng hồ luôn như mới.',
                'link' => '#'
            ]
        ];

        return view('index', compact('sanphams', 'thuonghieus', 'tintuc'));
    }
}
