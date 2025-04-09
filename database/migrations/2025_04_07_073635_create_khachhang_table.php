<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKhachhangTable extends Migration
{
    public function up()
    {
        Schema::create('khachhang', function (Blueprint $table) {
            $table->id('idkh');
            $table->string('tenkh', 30);
            $table->string('hokh', 20)->nullable();
            $table->string('diachikh', 100)->nullable();
            $table->unsignedBigInteger('idtk')->unique();
            $table->foreign('idtk')->references('idtk')->on('taikhoan')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('khachhang');
    }
}
