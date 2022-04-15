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
        Schema::create('master_pegawai', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->foreignId('store_id');
            $table->string('tempat_lahir');
            $table->string('tanggal_lahir');
            $table->string('tanggal_masuk');
            $table->string('agama');
            $table->string('gender');
            $table->string('alamat');
            $table->string('wa');
            $table->string('divisi');
            $table->string('jabatan');
            $table->string('active');
            $table->boolean('delete');
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
        Schema::dropIfExists('master_pegawai');
    }
};
