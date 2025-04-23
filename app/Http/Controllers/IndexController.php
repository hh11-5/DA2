<?php

namespace App\Http\Controllers;

use App\Models\SanPham;

class IndexController extends Controller
{
    public function index()
    {
        // Lấy 5 sản phẩm mới nhất dựa vào created_at
        $sanphams = SanPham::with('nhasanxuat')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return view('index', compact('sanphams'));
    }
}
