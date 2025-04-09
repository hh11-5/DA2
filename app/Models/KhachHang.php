<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KhachHang extends Model
{
    protected $table = 'khachhang';
    protected $primaryKey = 'idkh';
    public $timestamps = false;

    protected $fillable = [
        'tenkh',
        'hokh',
        'diachikh',
        'idtk',
    ];

    public function taiKhoan()
    {
        return $this->belongsTo(TaiKhoan::class, 'idtk');
    }
}
