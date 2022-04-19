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
            $table->foreignId('olahan_id')->references('id')->on('olahan')
                ->onDelete('cascade');
            $table->foreignId('bahan_id')->references('id')->on('bahan')
                ->onDelete('cascade');
            $table->boolean('draft')->default(true);
            $table->string('pemakaian');
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
