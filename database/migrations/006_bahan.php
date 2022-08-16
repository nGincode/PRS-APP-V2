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
            $table->string('nama', 50)->unique();
            $table->string('kode', 20)->unique();
            $table->string('kategori', 20);
            $table->string('satuan_pembelian', 10);
            $table->integer('harga');
            $table->string('satuan_pemakaian', 10);
            $table->string('konversi_pemakaian', 20);
            $table->string('satuan_pengeluaran', 10);
            $table->string('konversi_pengeluaran', 20);
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
