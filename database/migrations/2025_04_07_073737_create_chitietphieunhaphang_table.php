<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChitietphieunhaphangTable extends Migration
{
    public function up()
    {
        Schema::create('chitietphieunhaphang', function (Blueprint $table) {
            $table->unsignedBigInteger('idpn');
            $table->unsignedBigInteger('idsp');
            $table->decimal('gianhap', 18, 2);
            $table->integer('soluong');
            $table->primary(['idpn', 'idsp']);
            $table->foreign('idpn')->references('idpn')->on('phieunhaphang')->onDelete('cascade');
            $table->foreign('idsp')->references('idsp')->on('sanpham')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('chitietphieunhaphang');
    }
}
