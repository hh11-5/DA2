<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateTaikhoanTable extends Migration
{
    public function up()
    {
        Schema::create('taikhoan', function (Blueprint $table) {
            $table->id('idtk');
            $table->string('emailtk', 50)->unique()->nullable();
            $table->string('sdttk', 10)->unique()->nullable();
            $table->string('matkhau', 255);
            $table->boolean('trangthai')->default(1); // Thêm trường trạng thái, mặc định là 1 (kích hoạt)
        });

        DB::statement('ALTER TABLE taikhoan ADD CONSTRAINT chk_email_or_phone CHECK (emailtk IS NOT NULL OR sdttk IS NOT NULL)');
    }

    public function down()
    {
        Schema::dropIfExists('taikhoan');
    }
}
