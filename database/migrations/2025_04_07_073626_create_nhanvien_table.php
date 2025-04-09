<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNhanvienTable extends Migration
{
    public function up()
    {
        Schema::create('nhanvien', function (Blueprint $table) {
            $table->id('idnv');
            $table->string('tennv', 30);
            $table->string('honv', 20)->nullable();
            $table->string('diachinv', 100)->nullable();
            $table->unsignedBigInteger('idtk')->unique()->nullable();
            $table->foreign('idtk')->references('idtk')->on('taikhoan')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::dropIfExists('nhanvien');
    }
}
