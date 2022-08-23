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
        Schema::create('bahan_resep', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('resep_id');
            $table->foreign('resep_id')->references('id')->on('resep');

            $table->unsignedBigInteger('bahan_id')->nullable();
            $table->foreign('bahan_id')->references('id')->on('bahan');

            $table->unsignedBigInteger('olahan_id')->nullable();
            $table->foreign('olahan_id')->references('id')->on('olahan');

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
        Schema::dropIfExists('bahan_resep');
    }
};
