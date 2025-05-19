<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('post_logs', function (Blueprint $table) {
            $table->integer('user_id')->constrained()->cascadeOnDelete()->index();
            $table->morphs('postable');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::table('', function (Blueprint $table) {
            //
        });
    }
};
