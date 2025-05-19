<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('peoples', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('image')->nullable();
            $table->text('bio')->nullable();
            $table->string('gender', 10)->nullable();
            $table->date('birthday')->nullable();
            $table->date('death_date')->nullable();
            $table->json('arguments')->nullable();
            $table->string('imdb_id',25)->nullable();
            $table->string('tmdb_id',25)->nullable();
            $table->string('tmdb_image')->nullable();
            $table->enum('featured', ['active', 'disable'])->default('disable')->nullable();
            $table->timestamps();
        });

    }

    public function down()
    {
        Schema::dropIfExists('peoples');
    }
};
