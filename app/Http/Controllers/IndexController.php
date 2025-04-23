<?php

namespace App\Http\Controllers;

use App\Models\SanPham;

class IndexController extends Controller
{
    public function index()
    {
        $sanphams = SanPham::select('tensp', 'gia')->take(6)->get(); // Chỉ lấy 6 sản phẩm
        $tintuc = [
            [
                'tieude' => 'Top đồng hồ hot 2025',
                'hinhanh' => './Image/News1.jpg',
                'tomtat' => 'Khám phá những mẫu đồng hồ đang được ưa chuộng nhất hiện nay.',
                'link' => 'https://donghoduyanh.com/tu-van-giai-dap/top-20-mau-dong-ho-nam-trung-nien-dep-nhat-2025-ban-khong-the-bo-qua-n3606.html'
            ],
            [
                'tieude' => 'Đồng hồ cho doanh nhân',
                'hinhanh' => './Image/News2.jpg',
                'tomtat' => 'Gợi ý mẫu đồng hồ đẳng cấp phù hợp khi đi họp, gặp đối tác.',
                'link' => 'https://luxshopping.vn/tin-tuc/top-8-thuong-hieu-dong-ho-doanh-nhan-sang-trong-ua-chuong-99931.aspx'
            ],
            [
                'tieude' => 'Mẹo bảo quản đồng hồ',
                'hinhanh' => './Image/News3.jpeg',
                'tomtat' => 'Những điều cần biết để giữ đồng hồ luôn như mới.',
                'link' => 'https://donghoduyanh.com/tu-van-giai-dap/6-meo-cham-soc-dong-ho:-cach-giu-dong-ho-cua-ban-luon-trong-tinh-trang-tot-nhat-n3591.html'
            ]
        ];

        return view('index', compact('sanphams', 'tintuc'));
    }
}
