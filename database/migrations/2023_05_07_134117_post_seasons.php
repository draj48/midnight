<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('post_seasons', function (Blueprint $table) {
            $table->id();
            $table->foreignId('post_id')->constrained()->cascadeOnDelete();
            $table->string('season_number');
            $table->string('name')->nullable();
            $table->string('tmdb_id',25)->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('');
    }
};
