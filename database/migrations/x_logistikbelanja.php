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
        Schema::create('logistikbelanja', function (Blueprint $table) {
            $table->id();
            $table->string('store');
            $table->integer('gudang_id');
            $table->string('bill_no');
            $table->string('tgl');
            $table->string('total');
            $table->integer('status');
            $table->integer('upload');
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
        Schema::dropIfExists('logistik_belanja');
    }
};
