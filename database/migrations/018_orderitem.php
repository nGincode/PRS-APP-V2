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
        Schema::create('orderitem', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('users_id');
            $table->foreign('users_id')->references('id')->on('users');

            $table->unsignedBigInteger('store_id');
            $table->foreign('store_id')->references('id')->on('store');

            $table->unsignedBigInteger('order_id');
            $table->foreign('order_id')->references('id')->on('order');


            $table->unsignedBigInteger('bahan_id');
            $table->foreign('bahan_id')->references('id')->on('bahan');


            $table->integer('logistik');
            $table->date('tgl');
            $table->date('tgl_laporan');
            $table->string('nama', 30)->nullable();
            $table->string('qty_order')->nullable();
            $table->string('qty_deliv')->nullable();
            $table->string('qty_arrive')->nullable();
            $table->integer('harga')->nullable();
            $table->string('satuan', 10)->nullable();
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
        Schema::dropIfExists('orderitem');
    }
};
