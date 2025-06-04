<?php

namespace App\Http\Controllers;

use App\Models\Sanpham; 
use App\Models\NhaSanXuat;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->input('query');
        
        // Lấy sản phẩm theo từ khóa
        $products = Sanpham::where('tensp', 'like', "%{$query}%")
            ->orWhereHas('nhasanxuat', function($q) use ($query) {
                $q->where('tennhasx', 'like', "%{$query}%");
            })
            ->with('nhasanxuat')
            ->get();

        // Thêm dòng này để lấy danh sách chất liệu vỏ
        $chatLieuVos = Sanpham::select('clieuvo')
            ->whereNotNull('clieuvo')
            ->distinct()
            ->orderBy('clieuvo')
            ->pluck('clieuvo');

        // Truyền thêm biến $chatLieuVos vào view
        return view('layouts.results', compact('products', 'query', 'chatLieuVos'));
    }

    public function filter(Request $request)
    {
        try {
            $query = Sanpham::query();

            // Debug log
            \Log::info('Filter request:', $request->all());

            // Lọc theo giá
            if ($request->priceRange) {
                list($minPrice, $maxPrice) = explode('-', $request->priceRange);
                // Đảm bảo giá trị là số
                $minPrice = (int)$minPrice;
                $maxPrice = (int)$maxPrice;
                
                \Log::info("Filtering price between {$minPrice} and {$maxPrice}");

                $query->whereBetween('gia', [$minPrice, $maxPrice]);
            }

            // Lọc theo chất liệu vỏ
            if (!empty($request->clieuvo)) {
                $query->whereIn('clieuvo', (array)$request->clieuvo);
            }

            // Debug log query
            \Log::info('SQL Query:', [
                'sql' => $query->toSql(),
                'bindings' => $query->getBindings()
            ]);

            $products = $query->get();

            if ($products->isEmpty()) {
                return response()->json([
                    'error' => 'Không tìm thấy sản phẩm phù hợp với khoảng giá đã chọn'
                ]);
            }

            // Debug log results
            \Log::info('Found products count: ' . $products->count());

            return response()->json($products);
        } catch (\Exception $e) {
            \Log::error('Filter error: ' . $e->getMessage());
            return response()->json([
                'error' => 'Có lỗi xảy ra khi lọc sản phẩm'
            ], 500);
        }
    }

    public function index()
    {
        // Lấy tất cả sản phẩm
        $products = Sanpham::with('nhasanxuat')->get();
        
        // Lấy danh sách chất liệu vỏ
        $chatLieuVos = Sanpham::select('clieuvo')
            ->whereNotNull('clieuvo')
            ->distinct()
            ->orderBy('clieuvo')
            ->pluck('clieuvo');

        // Truyền empty query vì đây không phải kết quả tìm kiếm
        $query = '';

        return view('layouts.results', compact('products', 'query', 'chatLieuVos'));
    }
}