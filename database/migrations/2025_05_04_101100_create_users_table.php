<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('login', 12)->unique();
            $table->string('password', 200);
            $table->string('email', 30)->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->integer('votes')->default(0)->constrained('votes')->onDelete('cascade');
            $table->integer('polls')->default(0)->constrained('polls')->onDelete('cascade');
            $table->rememberToken();
            $table->string('google_id')->nullable();
            $table->string('role', 5);
            $table->date('birthdate')->nullable();
            $table->string('gender')->default("Не указан");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
};
