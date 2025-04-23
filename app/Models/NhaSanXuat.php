<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NhaSanXuat extends Model
{
    protected $table = 'nhasanxuat';
    protected $primaryKey = 'idnhasx';
    public $timestamps = false;

    protected $fillable = [
        'tennhasx',
        'diachi',
        'sdt',
        'email'
    ];

    public function sanphams()
    {
        return $this->hasMany(SanPham::class, 'idnhasx', 'idnhasx');
    }
}
