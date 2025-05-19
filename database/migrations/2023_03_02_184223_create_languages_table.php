<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up()
    {
        Schema::create('languages', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('code', 64)->unique('code');
            $table->string('name', 255);
        });

    }

    public function down()
    {
        Schema::dropIfExists('languages');
    }
};
