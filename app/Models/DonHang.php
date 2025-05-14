<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DonHang extends Model
{
    protected $table = 'donhang';
    protected $primaryKey = 'iddhang';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'iddhang',
        'ngaydathang',
        'idkh',
        'tongtien',
        'phivanchuyen',
        'trangthai'
    ];

    // Cast ngaydathang to datetime
    protected $casts = [
        'ngaydathang' => 'datetime'
    ];

    public function khachHang()
    {
        return $this->belongsTo(KhachHang::class, 'idkh');
    }

    public function chiTietDonHang()
    {
        return $this->hasMany(ChiTietDonHang::class, 'iddhang');
    }
}
