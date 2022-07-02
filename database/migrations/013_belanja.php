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
            $table->date('tgl');
            $table->string('nama');
            $table->string('kategori');
            $table->integer('qty')->nullable();
            $table->string('uom')->nullable();
            $table->string('harga')->nullable();
            $table->integer('store_id');
            $table->integer('bahan_id')->nullable();
            $table->string('konversi')->nullable();
            $table->string('item_uom')->nullable();
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
