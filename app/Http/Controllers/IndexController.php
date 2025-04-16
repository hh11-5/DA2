<?php

namespace App\Http\Controllers;

use App\Models\SanPham;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function index()
    {
        $sanphams = SanPham::take(5)->get(); // Lấy 5 sản phẩm
        return view('index', compact('sanphams'));
    }
}