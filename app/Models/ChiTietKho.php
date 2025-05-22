<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChiTietKho extends Model
{
    protected $table = 'chitietkho';
    protected $primaryKey = ['idkho', 'idsp'];
    public $incrementing = false;
    public $timestamps = true;

    protected $fillable = [
        'idkho',
        'idsp',
        'soluong'
    ];

    protected function setKeysForSaveQuery($query)
    {
        return $query->where('idkho', $this->getAttribute('idkho'))
                    ->where('idsp', $this->getAttribute('idsp'));
    }

    public function kho()
    {
        return $this->belongsTo(Kho::class, 'idkho', 'idkho');
    }

    public function sanPham()
    {
        return $this->belongsTo(SanPham::class, 'idsp', 'idsp');
    }
}
