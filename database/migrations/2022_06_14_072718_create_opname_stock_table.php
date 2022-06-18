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
        Schema::create('opnamestock', function (Blueprint $table) {
            $table->id();
            $table->date('tgl');
            $table->integer('store_id');
            $table->foreignId('bahan_id')->constrained();
            $table->string('status')->nullable();
            $table->string('nama')->nullable();
            $table->string('qty')->nullable();
            $table->string('qty_sebelum')->nullable();
            $table->boolean('delete')->default(false);
            $table->string('ket')->nullable();
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
        Schema::dropIfExists('opnamestock');
    }
};
