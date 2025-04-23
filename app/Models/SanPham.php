<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SanPham extends Model
{
    protected $table = 'sanpham';
    protected $primaryKey = 'idsp';
    public $timestamps = true;

    protected $fillable = [
        'masp',
        'tensp',
        'hinhsp',
        'gia',
        'xuatxu',
        'kieu',
        'clieuvo',
        'clieuday',
        'clieukinh',
        'khangnuoc',
        'tgbaohanh_nam',
        'idnhasx'
    ];

    public function nhasanxuat()
    {
        return $this->belongsTo(NhaSanXuat::class, 'idnhasx', 'idnhasx');
    }
}
