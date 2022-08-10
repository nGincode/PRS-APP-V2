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
        Schema::create('order', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('users_id');
            $table->foreign('users_id')->references('id')->on('users');

            $table->unsignedBigInteger('store_id');
            $table->foreign('store_id')->references('id')->on('store');

            $table->integer('logistik');

            $table->string('bill');
            $table->date('tgl');
            $table->string('nama', 20)->nullable();
            $table->string('nohp', 15)->nullable();
            $table->string('ket')->nullable();
            $table->boolean('up')->default(false);
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
        Schema::dropIfExists('order');
    }
};
