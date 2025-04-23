<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSanphamTable extends Migration
{
    public function up()
    {
        Schema::create('sanpham', function (Blueprint $table) {
            $table->id('idsp');
            $table->string('masp', 20)->unique();
            $table->string('tensp', 80);
            $table->string('hinhsp')->nullable();
            $table->decimal('gia', 18, 2);
            $table->string('xuatxu', 50)->nullable();
            $table->string('kieu', 20)->nullable();
            $table->string('clieuvo', 30)->nullable();
            $table->string('clieuday', 30)->nullable();
            $table->string('clieukinh', 30)->nullable();
            $table->string('khangnuoc', 30)->nullable();
            $table->integer('tgbaohanh_nam')->nullable();
            $table->unsignedBigInteger('idnhasx');
            $table->foreign('idnhasx')->references('idnhasx')->on('nhasanxuat')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('sanpham');
    }
}
