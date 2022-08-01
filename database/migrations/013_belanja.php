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
        Schema::create('belanja', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('users_id');
            $table->foreign('users_id')->references('id')->on('users');

            $table->unsignedBigInteger('store_id');
            $table->foreign('store_id')->references('id')->on('store');

            $table->unsignedBigInteger('bahan_id')->nullable();
            $table->foreign('bahan_id')->nullable()->references('id')->on('bahan');

            $table->dateTime('tgl');
            $table->string('nama', 30);
            $table->string('kategori', 20);
            $table->string('qty')->nullable();
            $table->string('uom', 20)->nullable();
            $table->integer('harga')->nullable();


            $table->string('stock')->nullable();
            $table->integer('stock_harga')->nullable();
            $table->string('stock_uom', 10)->nullable();
            $table->integer('total')->nullable();
            $table->string('ket')->nullable();
            $table->boolean('hutang')->default(false);
            $table->boolean('up')->default(false);
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
        Schema::dropIfExists('belanja');
    }
};
