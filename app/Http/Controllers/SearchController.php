<?php

namespace App\Http\Controllers;

use App\Models\Sanpham; 
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

        return view('layouts.results', compact('products', 'query')); // Sửa đường dẫn view
    }
}