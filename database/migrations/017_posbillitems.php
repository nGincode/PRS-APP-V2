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
        Schema::create('posbillitem', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('pos_id');
            $table->foreign('pos_id')->references('id')->on('pos');


            $table->unsignedBigInteger('bahan_id');
            $table->foreign('bahan_id')->references('id')->on('bahan');

            $table->date('tgl');
            $table->string('nama');
            $table->string('qty');
            $table->string('satuan');
            $table->string('harga');
            $table->string('total');
            $table->boolean('paid');
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
        Schema::dropIfExists('posbillitem');
    }
};
