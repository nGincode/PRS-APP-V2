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
        Schema::create('olahan', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 30);
            $table->string('kode', 20);
            $table->string('satuan_pengeluaran', 10);
            $table->string('satuan_penyajian', 10);
            $table->integer('konversi_penyajian');
            $table->string('hasil', 20)->nullable();
            $table->string('produksi', 20)->nullable();
            $table->boolean('draft')->default(true);
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
        Schema::dropIfExists('olahan');
    }
};
