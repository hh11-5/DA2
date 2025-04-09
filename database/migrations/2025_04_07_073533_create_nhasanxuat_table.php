<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNhasanxuatTable extends Migration
{
    public function up()
    {
        Schema::create('nhasanxuat', function (Blueprint $table) {
            $table->id('idnhasx');
            $table->string('tennhasx', 50);
        });
    }

    public function down()
    {
        Schema::dropIfExists('nhasanxuat');
    }
}
