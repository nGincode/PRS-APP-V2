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
        Schema::create('posbill', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('users_id');
            $table->foreign('users_id')->references('id')->on('users');

            $table->unsignedBigInteger('store_id');
            $table->foreign('store_id')->references('id')->on('store');

            $table->dateTime('tgl');
            $table->string('no_bill');
            $table->string('no_hp', 15)->nullable();
            $table->string('nama_bill', 50)->nullable();
            $table->string('store', 50)->nullable();
            $table->string('gross_total', 50);
            $table->string('disc', 2)->nullable();
            $table->string('tax', 2)->nullable();
            $table->string('total', 50);
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
        Schema::dropIfExists('posbill');
    }
};
