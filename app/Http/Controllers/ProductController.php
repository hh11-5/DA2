<?php

namespace App\Http\Controllers;

use App\Models\Sanpham;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Sanpham::with('nhasanxuat')->get();
        return view('layouts.results', [
            'products' => $products,
            'query' => 'Tất cả sản phẩm',
            'thuonghieus' => \App\Models\NhaSanXuat::all()
        ]);
    }

    public function show($id)
    {
        // Lấy thông tin sản phẩm và nhà sản xuất
        $sanpham = Sanpham::with('nhasanxuat')->findOrFail($id);

        // Tạo mảng hình ảnh (giả lập nhiều hình)
        $images = [
            $sanpham->hinhsp,
            $sanpham->hinhsp, // Thêm hình khác nếu có
            $sanpham->hinhsp,
            $sanpham->hinhsp
        ];

        // Lấy các sản phẩm cùng thương hiệu
        $relatedProducts = Sanpham::where('idnhasx', $sanpham->idnhasx)
            ->where('idsp', '!=', $sanpham->idsp)
            ->limit(4)
            ->get();

        return view('detail', compact('sanpham', 'images', 'relatedProducts'));
    }
}
