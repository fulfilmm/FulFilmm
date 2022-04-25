<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    { 
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('variant_id')->unsigned();
            $table->bigInteger('order_id')->unsigned()->nullable();
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
            $table->text('description')->nullable();
            $table->integer('quantity');
            $table->double('unit_price');
            $table->bigInteger('sell_unit')->unsigned()->nullable();
            $table->double('discount_promotion')->nullable();
            $table->double("total");
            $table->bigInteger('inv_id')->unsigned()->nullable();
            $table->foreign('inv_id')->references('id')->on('invoices')->onDelete('cascade');
            $table->string('creation_id');
            $table->tinyInteger('state');
            $table->double('cos_total')->nullable();
            $table->boolean('foc')->default(false);
            $table->index(['id']);
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
        Schema::dropIfExists('order_items');
    }
}
