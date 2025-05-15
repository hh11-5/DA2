<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PhanQuyen extends Model
{
    protected $table = 'phanquyen';
    protected $primaryKey = 'idpq';
    public $timestamps = false;

    protected $fillable = [
        'idtk',
        'idqh'
    ];

    public function taiKhoan()
    {
        return $this->belongsTo(TaiKhoan::class, 'idtk', 'idtk');
    }

    public function quyenHan()
    {
        return $this->belongsTo(QuyenHan::class, 'idqh', 'idqh');
    }
}
