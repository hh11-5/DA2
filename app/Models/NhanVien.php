<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NhanVien extends Model
{
    protected $table = 'nhanvien';
    protected $primaryKey = 'idnv'; // Sửa từ 'idtk' thành 'idnv'
    public $timestamps = false;

    protected $fillable = [
        'tennv',
        'honv',
        'diachinv',
        'idtk',
    ];

    public function taiKhoan()
    {
        return $this->belongsTo(TaiKhoan::class, 'idtk', 'idtk');
    }
}
