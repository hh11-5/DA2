<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNhasanxuatTable extends Migration
{
    public function up()
    {
        Schema::create('nhasanxuat', function (Blueprint $table) {
            $table->id('idnhasx');
            $table->string('tennhasx', 50);
            $table->string('diachi')->nullable(); // Thêm cột địa chỉ
            $table->string('sdt', 15)->nullable();
            $table->string('email', 50)->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('nhasanxuat');
    }
}
