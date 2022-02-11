<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStockUpdatedHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stock_updated_histories', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('stock_id')->unsigned();
            $table->bigInteger('variant_id')->unsigned();
            $table->bigInteger('emp_id')->unsigned();
            $table->double('before_balance');
            $table->double('updated_balance');
            $table->double('before_aval');
            $table->double('updated_aval');
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
        Schema::dropIfExists('stock_updated_histories');
    }
}
