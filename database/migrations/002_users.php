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
            $table->string('store', 50);

            $table->unsignedBigInteger('store_id');
            $table->foreign('store_id')->references('id')->on('store');

            $table->string('username', 20)->unique();
            $table->string('password');
            $table->string('email')->unique();
            $table->string('firstname', 20)->nullable();
            $table->string('lastname', 20)->nullable();
            $table->string('phone', 15)->nullable();
            $table->enum('gender', ['Pria', 'Wanita'])->nullable();
            $table->string('img')->nullable();
            $table->boolean('izin');
            $table->string('last_login', 20)->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
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
