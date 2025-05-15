<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChiTietDonHang extends Model
{
    protected $table = 'chitietdonhang';
    protected $primaryKey = ['iddhang', 'idsp'];
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'iddhang',
        'idsp',
        'soluong',
        'dongia',
        'giamgia',
        'thanhtien',
        'ghichu'
    ];

    protected $casts = [
        'dongia' => 'decimal:2',
        'giamgia' => 'decimal:2',
        'thanhtien' => 'decimal:2'
    ];

    public function donHang()
    {
        return $this->belongsTo(DonHang::class, 'iddhang', 'iddhang');
    }

    public function sanPham()
    {
        return $this->belongsTo(SanPham::class, 'idsp', 'idsp');
    }
}
