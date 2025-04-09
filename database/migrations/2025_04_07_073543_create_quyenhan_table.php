<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuyenhanTable extends Migration
{
    public function up()
    {
        Schema::create('quyenhan', function (Blueprint $table) {
            $table->id('idqh');
            $table->string('tenquyenhan', 20)->unique();
        });
    }

    public function down()
    {
        Schema::dropIfExists('quyenhan');
    }
}
