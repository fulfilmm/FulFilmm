<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStocksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stocks', function (Blueprint $table) {
            $table->id();
            $table->string('product_name');
            $table->double('stock_balance');
            $table->double('available');
            $table->double('ontheway_qty')->default(0);
            $table->double('alert_qty')->default(0)->nullable();
            $table->bigInteger('variant_id')->unsigned();
            $table->bigInteger('warehouse_id')->unsigned();
            $table->double('cos')->default(0);
            $table->text('product_location')->nullable();
            $table->bigInteger('branch_id')->unsigned();
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
        Schema::dropIfExists('stocks');
    }
}
