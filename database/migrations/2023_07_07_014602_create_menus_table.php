<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('menus', function (Blueprint $table) {
            $table->id();
            $table->enum('layout', ['all','header', 'footer'])->default('footer')->nullable();
            $table->string('title',191)->nullable();
            $table->string('url',191)->nullable();
            $table->string('route',191)->nullable();
            $table->string('icon',191)->nullable();
            $table->integer('sortable');
            $table->enum('static', ['active', 'disable'])->default('disable')->nullable();
            $table->enum('status', ['active', 'disable'])->default('disable')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('menus');
    }
};
