<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductReceiveItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_receive_items', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('variant_id')->unsigned();
            $table->double('demand');
            $table->double('qty')->nullable();
            $table->bigInteger('unit')->unsigned();
            $table->bigInteger('po_id')->unsigned();
            $table->bigInteger('receipt_id')->unsigned();
            $table->tinyInteger('is_stocked_in')->default(0);
            $table->double('price');
            $table->foreign('receipt_id')->references('id')->on('product_receives')->onDelete('cascade');
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
        Schema::dropIfExists('product_receive_items');
    }
}
