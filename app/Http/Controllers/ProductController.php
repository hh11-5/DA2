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

    public function getProductsByType($type)
    {
        $products = Sanpham::where('kieu', $type)->get();
        
        return view('products.by_type', [
            'products' => $products,
            'type' => $type
        ]);
    }

    public function filterProducts(Request $request)
    {
        try {
            $query = Sanpham::query();

            // Debug log
            \Log::info('Filter request:', $request->all());

            // Xử lý lọc theo khoảng giá
            if ($request->priceRange) {
                list($minPrice, $maxPrice) = explode('-', $request->priceRange);
                $query->whereBetween('gia', [(int)$minPrice, (int)$maxPrice]);
                
                // Debug log
                \Log::info('Price range:', ['min' => $minPrice, 'max' => $maxPrice]);
            }

            // Xử lý lọc theo chất liệu vỏ
            if (!empty($request->clieuvo)) {
                $query->whereIn('clieuvo', $request->clieuvo);
            }

            $products = $query->get();
            
            // Debug log
            \Log::info('Filtered products count:', ['count' => $products->count()]);

            return response()->json($products);
        } catch (\Exception $e) {
            \Log::error('Filter error: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
