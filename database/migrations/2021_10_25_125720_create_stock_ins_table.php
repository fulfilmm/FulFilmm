<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStockInsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stock_ins', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('variantion_id')->unsigned();
            $table->bigInteger('emp_id')->unsigned();//Auth Login
            $table->bigInteger('supplier_id')->unsigned()->nullable();
            $table->double('qty');
            $table->bigInteger('binlookup_id')->unsigned()->nullable();
            $table->bigInteger('branch_id')->unsigned();
            $table->bigInteger('warehouse_id')->unsigned();
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
        Schema::dropIfExists('stock_ins');
    }
}
