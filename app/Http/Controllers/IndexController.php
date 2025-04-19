<?php

namespace App\Http\Controllers;

use App\Models\SanPham;

class IndexController extends Controller
{
    public function index()
    {
        $sanphams = SanPham::select('tensp', 'gia')->get();
        return view('index', compact('sanphams'));
    }
}