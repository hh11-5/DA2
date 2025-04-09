<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChitietkhoTable extends Migration
{
    public function up()
    {
        Schema::create('chitietkho', function (Blueprint $table) {
            $table->unsignedBigInteger('idkho');
            $table->unsignedBigInteger('idsp');
            $table->integer('soluong');
            $table->primary(['idkho', 'idsp']);
            $table->foreign('idkho')->references('idkho')->on('kho')->onDelete('cascade');
            $table->foreign('idsp')->references('idsp')->on('sanpham')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('chitietkho');
    }
}
