<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuyenHan extends Model
{
    protected $table = 'quyenhan';
    protected $primaryKey = 'idqh';
    public $timestamps = false;

    protected $fillable = [
        'tenquyenhan'
    ];

    public function taiKhoan()
    {
        return $this->belongsToMany(TaiKhoan::class, 'phanquyen', 'idqh', 'idtk');
    }
}
