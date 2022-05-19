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
            $table->string('nama');
            $table->integer('bahan_id')->nullable();
            $table->string('kategori');
            $table->integer('qty');
            $table->string('uom');
            $table->string('harga');
            $table->string('master_uom')->nullable();
            $table->string('master_harga')->nullable();
            $table->string('total');
            $table->string('ket');
            $table->boolean('hutang')->default(false);
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
