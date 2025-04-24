<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChiTietGioHang extends Model
{
    protected $table = 'chitietgiohang';
    protected $primaryKey = ['idgh', 'idsp'];
    public $timestamps = false;
    public $incrementing = false;

    protected $fillable = [
        'idgh',
        'idsp',
        'soluong',
        'ngaythem'
    ];

    protected function setKeysForSaveQuery($query)
    {
        return $query->where('idgh', $this->getAttribute('idgh'))
                    ->where('idsp', $this->getAttribute('idsp'));
    }

    public function gioHang()
    {
        return $this->belongsTo(GioHang::class, 'idgh', 'idgh');
    }

    public function sanPham()
    {
        return $this->belongsTo(SanPham::class, 'idsp', 'idsp');
    }
}
