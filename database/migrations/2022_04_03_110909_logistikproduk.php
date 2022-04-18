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
        Schema::create('logistikproduk', function (Blueprint $table) {
            $table->id();
            $table->integer('gudang_id');
            $table->integer('user_id');
            $table->string('tgl_input');
            $table->string('name');
            $table->string('sku');
            $table->string('price');
            $table->string('price_old');
            $table->string('price_tgl');
            $table->string('hpp');
            $table->string('qty');
            $table->string('satuan');
            $table->string('image');
            $table->string('description');
            $table->integer('availability');
            $table->string('kadaluarsa');
            $table->string('trkhrup');
            $table->string('ke');
            $table->integer('tipe');
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
        Schema::dropIfExists('logistik_produk');
    }
};
