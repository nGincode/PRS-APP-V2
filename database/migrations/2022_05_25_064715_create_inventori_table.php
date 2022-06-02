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
        Schema::create('inventory', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bahan_id')->constrained();
            $table->integer('store_id');
            $table->string('qty')->nullable();
            $table->string('satuan')->nullable();
            $table->boolean('auto_harga')->nullable();
            $table->string('harga_last')->nullable();
            $table->string('harga_first')->nullable();
            $table->dateTime('tgl_harga')->nullable();
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
        Schema::dropIfExists('inventory');
    }
};
