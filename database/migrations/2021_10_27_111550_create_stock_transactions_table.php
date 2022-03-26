<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStockTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stock_transactions', function (Blueprint $table) {
            $table->id();
            $table->string('product_name');
            $table->bigInteger('variant_id')->unsigned();
            $table->bigInteger('stock_in')->unsigned()->nullable();
            $table->bigInteger('stock_out')->unsigned()->nullable();
            $table->bigInteger('return_id')->unsigned()->nullable();
            $table->bigInteger('warehouse_id')->unsigned();
            $table->bigInteger('emp_id')->unsigned();
            $table->bigInteger('creator_id')->unsigned();
            $table->double('balance');
            $table->bigInteger('contact_id')->unsigned()->nullable();
            $table->string('type');
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
        Schema::dropIfExists('stock_transactions');
    }
}
