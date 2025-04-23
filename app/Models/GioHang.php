<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class GioHang extends Model
{
    protected $table = 'giohang';
    protected $primaryKey = 'idgh';
    public $timestamps = false;
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'idgh',
        'idkh'
    ];

    public static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->idgh = (string) Str::uuid();
        });
    }

    public function khachHang()
    {
        return $this->belongsTo(KhachHang::class, 'idkh', 'idkh');
    }

    public function chiTietGioHang()
    {
        return $this->hasMany(ChiTietGioHang::class, 'idgh', 'idgh');
    }
}
