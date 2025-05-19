<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->enum('account_type', ['user', 'admin'])->default('user');
            $table->string('username')->unique();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('avatar')->nullable();
            $table->string('cover')->nullable();
            $table->text('about')->nullable();
            $table->text('billing')->nullable();

            $table->integer('plan_id')->nullable()->index('plan_id');
            $table->string('plan_amount', 32)->nullable();
            $table->string('plan_currency', 12)->nullable();
            $table->string('plan_interval', 16)->nullable();
            $table->string('plan_payment_method', 32)->nullable();
            $table->string('plan_subscription_id', 128)->nullable();
            $table->string('plan_subscription_status', 32)->nullable();
            $table->timestamp('plan_created_at')->nullable();
            $table->timestamp('plan_recurring_at')->nullable();
            $table->timestamp('plan_ends_at')->nullable();
            $table->string('socialite_type',64)->nullable();
            $table->string('socialite_id',191)->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
