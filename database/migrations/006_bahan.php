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
        Schema::create('bahan', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('kode');
            $table->string('kategori');
            $table->string('satuan_pembelian');
            $table->integer('harga');
            $table->string('satuan_pemakaian');
            $table->integer('konversi_pemakaian');
            $table->string('satuan_pengeluaran');
            $table->integer('konversi_pengeluaran');
            $table->json('pengguna')->nullable();
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
        Schema::dropIfExists('bahan');
    }
};
