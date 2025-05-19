<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('request_posts', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['movie', 'tv','anime'])->default('movie');
            $table->string('tmdb_id',25)->nullable();
            $table->string('title');
            $table->string('image')->nullable();
            $table->integer('request')->default('0')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('request_posts');
    }
};
