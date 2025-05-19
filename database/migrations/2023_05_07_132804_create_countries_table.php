<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('countries', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('code')->unique();
            $table->string('flag')->nullable();
            $table->enum('subtitle', ['active', 'disable'])->default('disable')->nullable();
            $table->enum('filter', ['active', 'disable'])->default('disable')->nullable();
        });

    }

    public function down()
    {
        Schema::dropIfExists('countries');
    }
};
