<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBillsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bills', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('bill_id')->unique();
            $table->bigInteger('vendor_id')->unsigned();
            $table->string('email');
            $table->text('billing_address')->nullable();
            $table->dateTime('bill_date');
            $table->dateTime('due_date');
            $table->string('status');
            $table->string('payment_method');
            $table->text('other_information')->nullable();
            $table->double('discount')->default(0.0);
            $table->double('grand_total');
            $table->double('due_amount');
            $table->bigInteger('emp_id')->unsigned();
            $table->string('invoice_id')->nullable();
            $table->dateTime('inv_date')->nullable();
            $table->string('po_id')->nullable();
            $table->string('category')->nullable();
            $table->index(['id','vendor_id']);
            $table->bigInteger('branch_id')->unsigned();
            $table->text('attachment')->nullable();
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
        Schema::dropIfExists('bills');
    }
}
