<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('post_genres', function (Blueprint $table) {
            $table->id();
            $table->foreignId('post_id')->index()->constrained()->cascadeOnDelete();
            $table->foreignId('genre_id')->index();
        });
    }

    public function down()
    {
        Schema::table('', function (Blueprint $table) {
            //
        });
    }
};
