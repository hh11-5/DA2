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
            $table->decimal('tongtien', 18, 2);
            $table->decimal('phivanchuyen', 18, 2);
            $table->enum('trangthai', ['Chờ xác nhận', 'Đã xác nhận', 'Đang giao', 'Đã giao', 'Đã hủy']);
            $table->foreign('idkh')->references('idkh')->on('khachhang')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('donhang');
    }
}
