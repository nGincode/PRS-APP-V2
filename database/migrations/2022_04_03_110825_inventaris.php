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
        Schema::create('inventaris', function (Blueprint $table) {
            $table->id();
            $table->string('store');
            $table->foreignId('store_id')->constrained('store');
            $table->foreignId('user_id')->constrained('users');
            $table->integer('user_id');
            $table->string('nama');
            $table->integer('divisi');
            $table->string('bagian');
            $table->string('img')->nullable();
            $table->integer('jumlah');
            $table->integer('bulan');
            $table->integer('tahun');
            $table->integer('harga')->nullable();
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
        Schema::dropIfExists('inventaris');
    }
};
