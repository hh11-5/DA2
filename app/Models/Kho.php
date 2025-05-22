<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kho extends Model
{
    protected $table = 'kho';
    protected $primaryKey = 'idkho';
    public $timestamps = false;

    protected $fillable = [
        'diachikho'
    ];

    public function chiTietKho()
    {
        return $this->hasMany(ChiTietKho::class, 'idkho', 'idkho');
    }
}
