<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGiohangTable extends Migration
{
    public function up()
    {
        Schema::create('giohang', function (Blueprint $table) {
            $table->uuid('idgh')->primary();
            $table->unsignedBigInteger('idkh');
            $table->timestamp('ngaybovaogio')->useCurrent();
            $table->foreign('idkh')->references('idkh')->on('khachhang')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('giohang');
    }
}
