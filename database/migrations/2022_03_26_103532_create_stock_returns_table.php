<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStockReturnsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stock_returns', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('inv_id')->unsigned()->nullable();
            $table->text('description')->nullable();
            $table->bigInteger('variant_id')->unsigned();
            $table->bigInteger('customer_id')->unsigned()->nullable();
            $table->bigInteger('emp_id')->unsigned()->nullable();
            $table->text('attachment')->nullable();
            $table->bigInteger('warehouse_id')->unsigned()->nullable();
            $table->bigInteger('sell_unit')->unsigned();
            $table->bigInteger('creator_id')->unsigned();
            $table->double('qty');
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
        Schema::dropIfExists('stock_returns');
    }
}
