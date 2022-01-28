<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRevenuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('revenues', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('customer_id')->unsigned();
            $table->bigInteger('invoice_id')->unsigned()->nullable();
            $table->double('amount');
            $table->string('reference')->nullable();
            $table->string('recurring')->nullable();
            $table->string('payment_method');
            $table->text('description')->nullable();
            $table->string('category');
            $table->dateTime('transaction_date');
            $table->text('attachment')->nullable();
            $table->tinyInteger('approve')->default(0);
            $table->bigInteger('approver_id')->unsigned();
            $table->bigInteger('emp_id')->unsigned();
            $table->string('currency');
            $table->bigInteger('advance_pay_id')->unsigned()->nullable();
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
        Schema::dropIfExists('revenues');
    }
}
