<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeliveryOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('delivery_orders', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('draft')->default('1');
            $table->dateTime('draft_time')->nullable();
            $table->tinyInteger('packing')->default(0);
            $table->dateTime('packing_time')->nullable();
            $table->tinyInteger('on_way')->default(0);
            $table->dateTime('onway_time')->nullable();
            $table->tinyInteger('receipt')->default(0);
            $table->dateTime('receipt_time')->nullable();
            $table->bigInteger('courier_id')->unsigned();
            $table->bigInteger('invoice_id')->unsigned();
            $table->bigInteger('customer_id')->unsigned();
            $table->string('delivery_id')->unique();
            $table->dateTime('delivery_date');
            $table->double('delivery_fee');
            $table->tinyInteger('paid_deli_fee')->default(0);
            $table->bigInteger('warehouse_id')->unsigned();
            $table->text('shipping_address');
            $table->text('uuid');
            $table->dateTime('reach_date')->nullable();
            $table->string('estimate_date')->nullable();
            $table->tinyInteger('seen')->default(0);
            $table->bigInteger('emp_id')->unsigned();
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
        Schema::dropIfExists('delivery_orders');
    }
}
