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
            $table->string('title')->nullable();
            $table->bigInteger('customer_id')->unsigned();
            $table->bigInteger('invoice_id')->unsigned()->nullable();
            $table->double('amount')->default(0);
            $table->string('reference')->nullable();
            $table->string('recurring')->nullable();
            $table->string('payment_method');
            $table->text('description')->nullable();
            $table->bigInteger('category')->unsigned();
            $table->dateTime('transaction_date');
            $table->text('attachment')->nullable();
            $table->tinyInteger('approve')->default(0);
            $table->bigInteger('cashier')->unsigned();
            $table->tinyInteger('is_cashintransit')->default(0);
            $table->bigInteger('cashier_account')->unsigned();
            $table->bigInteger('head_account')->unsigned();
            $table->bigInteger('emp_id')->unsigned();
            $table->string('currency')->default('MMK');
            $table->bigInteger('finance_manager')->unsigned();
            $table->text('second_attach')->nullable();
            $table->text('comment')->nullable();
            $table->tinyInteger('received')->default(0);
//            $table->bigInteger('coa_id')->unsigned();
            $table->bigInteger('advance_pay_id')->unsigned()->nullable();
            $table->bigInteger('branch_id')->unsigned();
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
