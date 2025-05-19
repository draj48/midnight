<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('post_peoples', function (Blueprint $table) {
            $table->integer('post_id')->constrained()->cascadeOnDelete()->index();
            $table->integer('people_id')->constrained()->cascadeOnDelete()->index();
        });
    }

    public function down()
    {
        Schema::dropIfExists('post_peoples');
    }
};
