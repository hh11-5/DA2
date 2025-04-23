<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChitietgiohangTable extends Migration
{
    public function up()
    {
        Schema::create('chitietgiohang', function (Blueprint $table) {
            $table->uuid('idgh');
            $table->unsignedBigInteger('idsp');
            $table->integer('soluong');
            $table->timestamp('ngaythem')->useCurrent();
            $table->primary(['idgh', 'idsp']);
            $table->foreign('idgh')->references('idgh')->on('giohang')->onDelete('cascade');
            $table->foreign('idsp')->references('idsp')->on('sanpham')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('chitietgiohang');
    }
}
