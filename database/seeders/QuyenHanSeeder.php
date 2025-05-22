<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\QuyenHan;

class QuyenHanSeeder extends Seeder
{
    public function run()
    {
        // Quyền hạn cơ bản
        QuyenHan::create([
            'idqh' => 1,
            'tenquyenhan' => 'admin'
        ]);
        QuyenHan::create([
            'idqh' => 2,
            'tenquyenhan' => 'staff'
        ]);
        QuyenHan::create([
            'idqh' => 3,
            'tenquyenhan' => 'customer'
        ]);
    }
}
