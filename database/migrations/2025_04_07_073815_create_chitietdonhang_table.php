<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChitietdonhangTable extends Migration
{
    public function up()
    {
        Schema::create('chitietdonhang', function (Blueprint $table) {
            $table->uuid('iddhang');
            $table->unsignedBigInteger('idsp');
            $table->integer('soluong');
            $table->decimal('dongia', 18, 2);
            $table->decimal('giamgia', 18, 2)->default(0);
            $table->decimal('thanhtien', 18, 2);
            $table->string('ghichu')->nullable();
            $table->primary(['iddhang', 'idsp']);
            $table->foreign('iddhang')->references('iddhang')->on('donhang')->onDelete('cascade');
            $table->foreign('idsp')->references('idsp')->on('sanpham')->onDelete('cascade');

        });
    }

    public function down()
    {
        Schema::dropIfExists('chitietdonhang');
    }
}
