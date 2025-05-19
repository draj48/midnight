<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('tags', function (Blueprint $table) {
            $table->id();
            $table->string('tag',191);
            $table->string('slug',191);
            $table->enum('type', ['article','post'])->default('post')->nullable();
        });
        Schema::create('post_tags', function (Blueprint $table) {
            $table->integer('post_id')->unsigned()->index();
            $table->integer('tagged_id')->unsigned()->index();
        });
        Schema::create('article_tags', function (Blueprint $table) {
            $table->integer('article_id')->unsigned()->index();
            $table->integer('tagged_id')->unsigned()->index();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tags');
    }
};
