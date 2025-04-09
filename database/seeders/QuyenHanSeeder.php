<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\QuyenHan;

class QuyenHanSeeder extends Seeder
{
    public function run()
    {
        QuyenHan::create(['tenquyenhan' => 'admin']);
        QuyenHan::create(['tenquyenhan' => 'staff']);
        QuyenHan::create(['tenquyenhan' => 'customer']);
    }
}
