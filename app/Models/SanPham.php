<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SanPham extends Model
{
    protected $table = 'sanpham';
    protected $primaryKey = 'idsp';
    public $timestamps = false;

    protected $fillable = [
        'masp',
        'tensp',
        'gia'
    ];
}