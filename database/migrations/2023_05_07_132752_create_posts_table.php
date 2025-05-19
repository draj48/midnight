<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['movie', 'tv','anime'])->default('movie');
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('title_sub');
            $table->text('tagline')->nullable();
            $table->text('overview')->nullable();
            $table->string('image')->nullable();
            $table->string('cover')->nullable();
            $table->string('slide')->nullable();
            $table->string('story')->nullable();
            $table->string('tmdb_image')->nullable();
            $table->string('collection',25)->nullable();
            $table->date('release_date')->nullable();
            $table->string('runtime',25)->nullable();
            $table->string('vote_average',25)->nullable();
            $table->integer('country_id')->nullable()->index();
            $table->string('trailer')->nullable();
            $table->string('quality',25)->nullable();
            $table->json('arguments')->nullable();
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->string('imdb_id',25)->nullable();
            $table->string('tmdb_id',25)->nullable();
            $table->integer('view')->default('0')->nullable();
            $table->enum('featured', ['active', 'disable'])->default('disable');
            $table->enum('slider', ['active', 'disable'])->default('disable');
            $table->enum('member', ['active', 'disable'])->default('disable');
            $table->enum('comment', ['active', 'disable'])->default('disable');
            $table->enum('status', ['publish', 'draft', 'schedule'])->default('draft');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('posts');
    }
};
