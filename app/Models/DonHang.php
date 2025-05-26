<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class DonHang extends Model
{
    protected $table = 'donhang';
    protected $primaryKey = 'iddhang';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'iddhang',
        'ngaydathang',
        'idkh',
        'tongtien',
        'phivanchuyen',
        'trangthai'
    ];

    // Chỉ định các trường ngày tháng
    protected $dates = ['ngaydathang'];

    // Đảm bảo ngày được parse thành Carbon khi lấy từ DB
    protected $casts = [
        'ngaydathang' => 'datetime'
    ];

    // Chuyển ngày thành Carbon khi lưu vào DB
    public function setNgaydathangAttribute($value)
    {
        $this->attributes['ngaydathang'] = Carbon::parse($value);
    }

    // Định nghĩa các trạng thái đơn hàng
    const STATUSES = [
        0 => 'Chờ xác nhận',
        1 => 'Đã xác nhận',
        2 => 'Đang giao',
        3 => 'Đã giao',
        4 => 'Đã hủy'
    ];

    // Định nghĩa màu cho các trạng thái
    const STATUS_CLASSES = [
        0 => 'secondary', // Chờ xác nhận
        1 => 'info',      // Đã xác nhận
        2 => 'primary',   // Đang giao
        3 => 'success',   // Đã giao
        4 => 'danger'     // Đã hủy
    ];

    public function getStatusTextAttribute()
    {
        return self::STATUSES[$this->trangthai] ?? 'Không xác định';
    }

    public function getStatusClassAttribute()
    {
        return self::STATUS_CLASSES[$this->trangthai] ?? 'secondary';
    }

    public function khachHang()
    {
        return $this->belongsTo(KhachHang::class, 'idkh');
    }

    public function chiTietDonHang()
    {
        return $this->hasMany(ChiTietDonHang::class, 'iddhang');
    }
}
