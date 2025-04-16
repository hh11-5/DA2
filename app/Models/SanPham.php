<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SanPham extends Model
{
    protected $table = 'sanpham';
    protected $primaryKey = 'idsp';
    public $timestamps = false;

    protected $fillable = [
        'tensp',
        'gia',
        'hinhsp',
        'idsp'
    ];
}