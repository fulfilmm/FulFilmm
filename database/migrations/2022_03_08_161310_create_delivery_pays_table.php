<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeliveryPaysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('delivery_pays', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('delivery_id')->unsigned();
            $table->string('delivery_code');
            $table->double('delivery_fee');
            $table->double('invoice_amount');
            $table->tinyInteger('paid_delivery_fee')->default(0);
            $table->tinyInteger('receiver_invoice_amount')->default(0);
            $table->double('due_amount');
            $table->bigInteger('courier_id')->unsigned();
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
        Schema::dropIfExists('delivery_pays');
    }
}
