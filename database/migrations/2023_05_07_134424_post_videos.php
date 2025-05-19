<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('post_videos', function (Blueprint $table) {
            $table->id();
            $table->morphs('postable');
            $table->string('label')->nullable();
            $table->string('type');
            $table->string('link');
        });
    }

    public function down()
    {
        Schema::dropIfExists('');
    }
};
