<?php

namespace App\Http\Controllers;

use App\Models\SanPham;
use App\Models\NhaSanXuat;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    public function show($id)
    {
        // Lấy sản phẩm theo id nhà sản xuất
        $products = SanPham::where('idnhasx', $id)
                          ->select('idsp', 'tensp', 'gia', 'hinhsp')
                          ->get();
                          
        return response()->json($products);
    }

    public function brandPage($id)
    {
        $brand = NhaSanXuat::findOrFail($id);
        $products = SanPham::where('idnhasx', $id)
                          ->select('idsp', 'tensp', 'gia', 'hinhsp')
                          ->get();
        
        return view('brands.show', compact('brand', 'products'));
    }

    public function getProducts($id)
    {
        try {
            $products = SanPham::where('idnhasx', $id)->get();
            return response()->json($products);
        } catch (\Exception $e) {
            \Log::error('Lỗi khi lấy sản phẩm: ' . $e->getMessage());
            return response()->json(['error' => 'Có lỗi xảy ra khi tải sản phẩm'], 500);
        }
    }
}