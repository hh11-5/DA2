<?php
namespace App\Http\Controllers;

use App\Models\Sanpham;
use App\Models\NhaSanXuat;

class HomeController extends Controller 
{
    public function index()
    {
        // Lấy 6 sản phẩm mới nhất dựa vào thời gian tạo
        $sanphams = Sanpham::latest()
                          ->take(6)
                          ->get();

        $thuonghieus = NhaSanXuat::all();
        
        // Get tin tức
        $tintuc = [
            // ...existing news data...
        ];

        return view('index', compact('sanphams', 'thuonghieus', 'tintuc'));
    }
}