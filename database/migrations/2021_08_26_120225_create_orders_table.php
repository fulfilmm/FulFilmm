<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_id');
            $table->bigInteger('customer_id')->unsigned();
            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
            $table->double('total');
            $table->double('grand_total');
            $table->bigInteger('approver_id')->unsigned();
            $table->dateTime('expected_arrival_date')->nullable();
            $table->string('status')->nullable();
            $table->text('comment')->nullable();
            $table->string('phone');
            $table->string('email');
            $table->text('address');
            $table->string('payment_method');
            $table->string('payment_term');
            $table->dateTime('order_date');
            $table->bigInteger('tax_id')->unsigned();
            $table->double('discount')->nullable();
            $table->double('tax_amount')->nullable();
            $table->bigInteger('quotation_id')->unsigned()->nullable();
            $table->string('shipping_type')->nullable();
            $table->string('shipping_address')->nullable();
            $table->string('billing_address')->nullable();
            $table->bigInteger('emp_id')->unsigned();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
