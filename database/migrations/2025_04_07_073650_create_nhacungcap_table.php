<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNhacungcapTable extends Migration
{
    public function up()
    {
        Schema::create('nhacungcap', function (Blueprint $table) {
            $table->id('idnhacc');
            $table->string('tennhacc', 50);
            $table->string('sodtnhacc', 10)->nullable();
            $table->string('diachinhacc', 100)->nullable();
            $table->string('emailnhacc', 50)->unique()->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('nhacungcap');
    }
}
