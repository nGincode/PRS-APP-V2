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
        Schema::create('bahan_olahan', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('olahan_id');
            $table->foreign('olahan_id')->references('id')->on('olahan');

            $table->unsignedBigInteger('bahan_id')->nullable();
            $table->foreign('bahan_id')->references('id')->on('bahan');

            $table->unsignedBigInteger('bahanolahan_id')->nullable();
            $table->foreign('bahanolahan_id')->references('id')->on('olahan');

            $table->string('pemakaian')->default(0);
            $table->boolean('draft')->default(true);
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
        Schema::dropIfExists('bahan_olahan');
    }
};
