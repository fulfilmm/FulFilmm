<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoiceItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoice_items', function (Blueprint $table) {
            $table->id();
            $table->bigInteger("product_id")->unsigned();
            $table->text('description')->nullable();
            $table->integer('quantity');
            $table->integer("tax_id");
            $table->string('discount');
            $table->string("discount_type");
            $table->double('unit_price');
            $table->string("currency_unit");
            $table->double("total");
            $table->bigInteger('inv_id')->unsigned()->nullable();
            $table->foreign("inv_id")->references('id')->on('invoices')->onDelete("cascade");
            $table->string("creation_id");
            $table->index(['id','inv_id']);
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
        Schema::dropIfExists('invoice_items');
    }
}
