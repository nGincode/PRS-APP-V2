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
            $table->unsignedBigInteger('store_id');
            $table->foreign('store_id')->references('id')->on('store');

            $table->unsignedBigInteger('bahan_id')->nullable();
            $table->foreign('bahan_id')->nullable()->references('id')->on('bahan');

            $table->date('tgl');
            $table->string('nama');
            $table->string('kategori');
            $table->integer('qty')->nullable();
            $table->string('uom')->nullable();
            $table->string('harga')->nullable();


            $table->string('stock')->nullable();
            $table->string('stock_harga')->nullable();
            $table->string('stock_uom')->nullable();
            $table->string('total')->nullable();
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
