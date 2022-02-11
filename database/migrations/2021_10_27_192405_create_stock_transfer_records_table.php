<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStockTransferRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stock_transfer_records', function (Blueprint $table) {
            $table->id();
            $table->string('product_name');
            $table->bigInteger('variant_id')->unsigned();
            $table->bigInteger('from_warehouse')->unsigned();
            $table->bigInteger('to_warehouse')->unsigned();
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
        Schema::dropIfExists('stock_transfer_records');
    }
}
