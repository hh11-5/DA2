<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePhanquyenTable extends Migration
{
    public function up()
    {
        Schema::create('phanquyen', function (Blueprint $table) {
            $table->unsignedBigInteger('idtk');
            $table->unsignedBigInteger('idqh');
            $table->primary(['idtk', 'idqh']);
            $table->foreign('idtk')->references('idtk')->on('taikhoan')->onDelete('cascade');
            $table->foreign('idqh')->references('idqh')->on('quyenhan')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('phanquyen');
    }
}
