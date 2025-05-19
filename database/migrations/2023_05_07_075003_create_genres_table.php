<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('genres', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->text('icon')->nullable();
            $table->text('color')->nullable();
            $table->string('meta_title')->nullable();
            $table->string('meta_description')->nullable();
            $table->enum('featured', ['active', 'disable'])->default('disable')->nullable();
            $table->enum('footer', ['active', 'disable'])->default('disable')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('categories');
    }
};
