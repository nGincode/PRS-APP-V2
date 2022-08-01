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
        Schema::create('peralatan', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 30);
            $table->string('kode', 20);
            $table->string('kategori', 20);
            $table->string('satuan_pembelian', 20);
            $table->integer('harga');
            $table->string('satuan_pemakaian', 20);
            $table->string('konversi_pemakaian', 20);
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
        Schema::dropIfExists('peralatan');
    }
};
