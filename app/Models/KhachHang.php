<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KhachHang extends Model
{
    protected $table = 'khachhang';
    protected $primaryKey = 'idkh';
    public $timestamps = false; // Thêm dòng này

    protected $fillable = [
        'hokh',
        'tenkh',
        'diachikh',
        'idtk'
    ];

    public function taiKhoan()
    {
        return $this->belongsTo(TaiKhoan::class, 'idtk', 'idtk');
    }
}
