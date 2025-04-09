<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDonhangHuyTable extends Migration
{
    public function up()
    {
        Schema::create('donhang_huy', function (Blueprint $table) {
            $table->uuid('iddhuy')->primary();
            $table->uuid('iddh');
            $table->foreign('iddh')->references('iddhang')->on('donhang')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('donhang_huy');
    }
}
