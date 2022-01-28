<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuotationItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quotation_items', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('variant_id')->unsigned();
            $table->text("description")->nullable();
            $table->double("quantity");
            $table->bigInteger('discount_id')->unsigned()->nullable();
            $table->double("price");
            $table->bigInteger('unit_id')->unsigned();
            $table->string("quotation_id");
            $table->double("total_amount");
            $table->index('id','product_id');
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
        Schema::dropIfExists('quotation_items');
    }
}
