<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('user_id')->index('user_id');
            $table->unsignedInteger('plan_id')->index('plan_id');
            $table->string('payment_id', 128)->index('payment_id');
            $table->string('payment_method', 32)->index('payment_method');
            $table->string('amount', 32);
            $table->string('currency', 12);
            $table->string('interval', 16);
            $table->enum('status', ['completed', 'pending', 'cancelled'])->default('pending');
            $table->text('coupons')->nullable();
            $table->text('taxes')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('payments');
    }
};
