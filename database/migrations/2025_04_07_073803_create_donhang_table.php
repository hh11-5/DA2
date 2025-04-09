<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDonhangTable extends Migration
{
    public function up()
    {
        Schema::create('donhang', function (Blueprint $table) {
            $table->uuid('iddhang')->primary();
            $table->timestamp('ngaydathang')->useCurrent();
            $table->unsignedBigInteger('idkh');
            $table->foreign('idkh')->references('idkh')->on('khachhang')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('donhang');
    }
}
