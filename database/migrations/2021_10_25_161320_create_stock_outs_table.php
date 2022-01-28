<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStockOutsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stock_outs', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('variantion_id')->unsigned();
            $table->string('type');
            $table->bigInteger('emp_id')->unsigned();//select option
            $table->bigInteger('customer_id')->unsigned()->nullable();
            $table->bigInteger('invoice_id')->unsigned()->nullable();
            $table->bigInteger('approver_id')->unsigned();
            $table->bigInteger('courier_id')->unsigned()->nullable();
            $table->bigInteger('warehouse_id')->unsigned()->nullable();
            $table->bigInteger('sell_unit')->unsigned();
            $table->double('qty');
            $table->text('description')->nullable();
            $table->tinyInteger('approve')->default(0);
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
        Schema::dropIfExists('stock_outs');
    }
}
