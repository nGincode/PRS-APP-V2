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
        Schema::create('inventory', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('users_id');
            $table->foreign('users_id')->references('id')->on('users');

            $table->unsignedBigInteger('bahan_id');
            $table->foreign('bahan_id')->references('id')->on('bahan');

            $table->unsignedBigInteger('store_id');
            $table->foreign('store_id')->references('id')->on('store');

            $table->string('qty')->nullable();
            $table->string('satuan')->nullable();
            $table->boolean('auto_harga')->nullable();
            $table->string('harga_last')->nullable();
            $table->string('harga_first')->nullable();
            $table->dateTime('tgl_harga')->nullable();
            $table->string('margin')->nullable();
            $table->boolean('delete')->default(false);
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
        Schema::dropIfExists('inventory');
    }
};
