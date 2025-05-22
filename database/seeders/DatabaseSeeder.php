<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            QuyenHanSeeder::class,
            AdminStaffSeeder::class,
            SanPhamSeeder::class,
            KhoSeeder::class
        ]);
    }
}
