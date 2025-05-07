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
        
        $products = Sanpham::where('tensp', 'ilike', "%{$query}%")
            ->orWhere('gia', 'like', "%{$query}%")
            ->orWhereHas('nhasanxuat', function($q) use ($query) {
                $q->where('tennhasx', 'ilike', "%{$query}%");
            })
            ->with('nhasanxuat')
            ->get();

        // Thêm dữ liệu thương hiệu
        $thuonghieus = NhaSanXuat::all();

        return view('layouts.results', compact('products', 'query', 'thuonghieus')); // Sửa đường dẫn view
    }

    public function filter(Request $request)
    {
        $query = Sanpham::query();

        // Lọc theo giá
        if ($request->minPrice) {
            $query->where('gia', '>=', $request->minPrice);
        }
        if ($request->maxPrice) {
            $query->where('gia', '<=', $request->maxPrice);
        }

        // Lọc theo thương hiệu
        if (!empty($request->brands)) {
            $query->whereIn('idnhasx', $request->brands);
        }

        // Lọc theo kiểu đồng hồ
        if (!empty($request->types)) {
            $query->whereIn('kieu', $request->types);
        }

        // Lọc theo chất liệu
        if (!empty($request->materials)) {
            $query->where(function($q) use ($request) {
                $q->whereIn('clieuvo', $request->materials)
                  ->orWhereIn('clieuday', $request->materials);
            });
        }

        // Lọc theo chất liệu vỏ
        if (!empty($request->clieuvo)) {
            $query->whereIn('clieuvo', $request->clieuvo);
        }

        $products = $query->with('nhasanxuat')->get();
        
        return response()->json($products);
    }
}