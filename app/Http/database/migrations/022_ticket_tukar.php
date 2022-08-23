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
        Schema::create('ticket_tukar', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ticket_id');
            $table->foreign('ticket_id')->references('id')->on('ticket');

            $table->string('kode', 40)->unique();
            $table->string('nama', 40);
            $table->string('wa', 15);
            $table->string('email', 40);
            $table->integer('jumlah');
            $table->string('pembuat', 40);
            $table->string('di')->nullable();
            $table->string('harga', 11)->nullable();
            $table->string('ke', 40)->nullable();
            $table->dateTime('claim')->nullable();
            $table->date('berlaku')->nullable();
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
        Schema::dropIfExists('ticket_tukar');
    }
};
