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
        Schema::create('opnamestock', function (Blueprint $table) {
            $table->id();
            $table->dateTime('tgl');

            $table->unsignedBigInteger('users_id');
            $table->foreign('users_id')->references('id')->on('users');

            $table->unsignedBigInteger('store_id');
            $table->foreign('store_id')->references('id')->on('store');

            $table->unsignedBigInteger('bahan_id');
            $table->foreign('bahan_id')->references('id')->on('bahan');


            $table->enum('status', ['Tambah', 'Kurang'])->nullable();
            $table->string('nama', 30)->nullable();
            $table->string('uom', 10)->nullable();
            $table->string('qty')->nullable();
            $table->string('qty_sebelum')->nullable();
            $table->boolean('delete')->default(false);
            $table->string('ket')->nullable();
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
        Schema::dropIfExists('opnamestock');
    }
};
