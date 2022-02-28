<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchaseOrderItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase_order_items', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('po_id')->unsigned()->nullable();
            $table->foreign('po_id')->references('id')->on('purchase_orders')->onDelete('cascade');
            $table->bigInteger('variant_id')->unsigned();
            $table->text('description')->nullable();
            $table->double('qty');
            $table->double('price')->default(0);
            $table->string('creation_id');
            $table->double('total')->default(0);
            $table->bigInteger('unit')->unsigned();
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
        Schema::dropIfExists('purchase_order_items');
    }
}
