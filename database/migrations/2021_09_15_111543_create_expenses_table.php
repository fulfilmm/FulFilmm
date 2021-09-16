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
            $table->double('amount');
            $table->string('account');
            $table->bigInteger('vendor_id')->unsigned();
            $table->string('reference');
            $table->string('recurring')->nullable();
            $table->string('payment_method');
            $table->text('description')->nullable();
            $table->string('category');
            $table->dateTime('transaction_date');
            $table->text('attachement')->nullable();
            $table->bigInteger('emp_id');
            $table->string('currency');
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
        Schema::dropIfExists('expenses');
    }
}
