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
        Schema::create('posbillitem', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pos_id')->constrained();
            $table->foreignId('bahan_id')->constrained();
            $table->date('tgl');
            $table->string('nama');
            $table->string('qty');
            $table->string('satuan');
            $table->string('harga');
            $table->string('total');
            $table->boolean('paid');
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
        Schema::dropIfExists('posbillitem');
    }
};