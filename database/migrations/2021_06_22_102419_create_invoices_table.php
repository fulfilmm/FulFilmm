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
            $table->string('email');
            $table->text('customer_address');
            $table->text('billing_address');
            $table->dateTime('invoice_date');
            $table->dateTime('due_date');
            $table->string('status');
            $table->string('payment_method');
            $table->text('other_information')->nullable();
            $table->double('grand_total');
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
