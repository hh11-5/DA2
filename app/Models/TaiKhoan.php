<?php
namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class TaiKhoan extends Authenticatable
{
    protected $table = 'taikhoan';
    protected $primaryKey = 'idtk';
    public $timestamps = false;
    protected $rememberTokenName = false;

    protected $fillable = [
        'emailtk',
        'sdttk',
        'matkhau',
        'trangthai'
    ];

    protected $hidden = [
        'matkhau',
    ];

    // Add these required methods
    public function getAuthIdentifier()
    {
        return $this->getAttribute($this->getAuthIdentifierName());
    }

    public function getAuthIdentifierName()
    {
        return 'idtk';
    }

    public function getAuthPassword()
    {
        return $this->matkhau;
    }

    // Implement remember token methods (even if not used)
    public function getRememberToken()
    {
        return null;
    }

    public function setRememberToken($value)
    {
    }

    public function getRememberTokenName()
    {
        return null;
    }

    // Existing relationships
    public function khachHang()
    {
        return $this->hasOne(KhachHang::class, 'idtk', 'idtk');
    }

    public function nhanVien()
    {
        return $this->hasOne(NhanVien::class, 'idtk', 'idtk');
    }

    public function phanQuyen()
    {
        return $this->hasOne(PhanQuyen::class, 'idtk', 'idtk');
    }

    /**
     * Get the value of the model's primary key.
     */
    public function getKey()
    {
        return $this->getAttribute($this->getAuthIdentifierName());
    }
}
