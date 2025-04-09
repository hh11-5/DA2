<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKhoTable extends Migration
{
    public function up()
    {
        Schema::create('kho', function (Blueprint $table) {
            $table->id('idkho');
            $table->string('diachikho', 100);
        });
    }

    public function down()
    {
        Schema::dropIfExists('kho');
    }
}
