<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePhieunhaphangTable extends Migration
{
    public function up()
    {
        Schema::create('phieunhaphang', function (Blueprint $table) {
            $table->id('idpn');
            $table->timestamp('ngaynhap')->useCurrent();
            $table->unsignedBigInteger('idnv')->nullable();
            $table->unsignedBigInteger('idnhacc')->nullable();
            $table->unsignedBigInteger('idkho');
            $table->foreign('idnv')->references('idnv')->on('nhanvien')->onDelete('set null');
            $table->foreign('idnhacc')->references('idnhacc')->on('nhacungcap')->onDelete('set null');
            $table->foreign('idkho')->references('idkho')->on('kho')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('phieunhaphang');
    }
}
