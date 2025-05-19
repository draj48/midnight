<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('plans', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('name', 255);
            $table->text('description')->nullable();
            $table->string('currency', 12);
            $table->enum('interval', ['month', 'year'])->default('month')->nullable();
            $table->integer('price')->default('0')->nullable();
            $table->integer('sorting')->nullable();
            $table->text('coupons')->nullable();
            $table->text('taxes')->nullable();
            $table->enum('featured', ['active', 'disable'])->default('disable')->nullable();
            $table->enum('status', ['active', 'disable'])->default('active')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('plans');
    }
};
