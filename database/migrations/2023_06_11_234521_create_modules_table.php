<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('modules', function (Blueprint $table) {
            $table->id();
            $table->string('page', 255);
            $table->string('title', 255);
            $table->string('slug', 255);
            $table->json('arguments')->nullable();
            $table->integer('sortable');
            $table->enum('status', ['active', 'disable'])->default('active')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('modules');
    }
};
