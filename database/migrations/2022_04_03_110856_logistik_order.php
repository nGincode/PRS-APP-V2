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
        Schema::create('logistik_order', function (Blueprint $table) {
            $table->id();
            $table->integer('gudang_id');
            $table->string('store');
            $table->integer('store_id');
            $table->integer('user_id');
            $table->integer('kasir');
            $table->string('bill_no');
            $table->string('customer_name');
            $table->string('outletorder');
            $table->string('customer_address');
            $table->string('customer_phone');
            $table->string('date_time');
            $table->string('tgl_pesan');
            $table->string('gross_amount');
            $table->string('service_charge_rate');
            $table->string('service_charge');
            $table->string('vat_charge_rate');
            $table->string('vat_charge');
            $table->string('net_amount');
            $table->string('discount');
            $table->string('paid_status');
            $table->string('status_up');
            $table->string('tunai');
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
        Schema::dropIfExists('logistik_order');
    }
};
