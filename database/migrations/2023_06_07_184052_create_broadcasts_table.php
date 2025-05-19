<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('broadcasts', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('overview')->nullable();
            $table->string('image')->nullable();
            $table->string('cover')->nullable();
            $table->json('arguments')->nullable();
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->integer('view')->default('0')->nullable();
            $table->enum('featured', ['active', 'disable'])->default('disable');
            $table->enum('member', ['active', 'disable'])->default('disable');
            $table->enum('comment', ['active', 'disable'])->default('disable');
            $table->enum('status', ['publish', 'draft', 'schedule'])->default('draft');



            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('broadcasts');
    }
};
