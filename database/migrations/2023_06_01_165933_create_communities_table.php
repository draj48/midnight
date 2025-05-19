<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('communities', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->constrained()->cascadeOnDelete()->index();
            $table->integer('post_id')->constrained()->cascadeOnDelete()->index()->nullable();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->enum('comment', ['active', 'disable'])->default('disable');
            $table->enum('featured', ['active', 'disable'])->default('disable');
            $table->enum('status', ['publish', 'draft', 'schedule'])->default('draft');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('communities');
    }
};
