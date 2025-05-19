<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('post_episodes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('post_id')->constrained()->cascadeOnDelete();
            $table->foreignId('post_season_id')->constrained()->cascadeOnDelete();
            $table->string('season_number',25)->nullable();
            $table->string('name')->nullable();
            $table->string('episode_number',25)->nullable();
            $table->text('overview')->nullable();
            $table->string('image')->nullable();
            $table->string('runtime',25)->nullable();
            $table->string('quality',25)->nullable();
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->string('tmdb_id',25)->nullable();
            $table->string('tmdb_image')->nullable();
            $table->integer('view')->default('0')->nullable();
            $table->enum('featured', ['active', 'disable'])->default('disable');
            $table->enum('comment', ['active', 'disable'])->default('disable');
            $table->enum('status', ['publish', 'draft', 'schedule'])->default('draft');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('post_episodes');
    }
};
