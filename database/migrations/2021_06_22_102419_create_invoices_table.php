<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('invoice_id');
            $table->bigInteger('customer_id')->unsigned();
            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
            $table->string('email');
            $table->text('customer_address');
            $table->text('billing_address');
            $table->dateTime('invoice_date');
            $table->dateTime('due_date');
            $table->string('status');
            $table->string('payment_method');
            $table->text('other_information')->nullable();
            $table->double('grand_total');
            $table->double('discount')->nullable();
            $table->bigInteger('tax_id')->unsigned();
            $table->double('total');
            $table->double('tax_amount')->nullable();
            $table->boolean('mark_sent')->default(false);
            $table->boolean('send_email')->default(false);
            $table->bigInteger('emp_id');
            $table->index(['id','customer_id']);
            $table->bigInteger('order_id')->unsigned()->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('invoices');
    }
}
