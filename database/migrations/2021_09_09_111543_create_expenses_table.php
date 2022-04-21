<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExpensesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('expenses', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->double('amount');
            $table->bigInteger('bill_id')->unsigned()->nullable();
            $table->bigInteger('vendor_id')->unsigned()->nullable();
            $table->string('reference')->nullable();
            $table->string('recurring')->nullable();
            $table->string('payment_method');
            $table->text('description')->nullable();
            $table->bigInteger('category')->unsigned();
            $table->dateTime('transaction_date');
            $table->text('attachment')->nullable();
            $table->tinyInteger('approve')->default(0);
            $table->bigInteger('approver_id')->unsigned();
            $table->bigInteger('emp_id');
            $table->bigInteger('coa_id')->unsigned();
            $table->string('currency');
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
        Schema::dropIfExists('expenses');
    }
}
