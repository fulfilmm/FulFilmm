<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->bigInteger("tax")->unsigned();
            $table->foreign("tax")->references("id")->on("products_taxes")->onDelete("cascade");
            $table->text("description");
            $table->double("sale_price");
            $table->string("model_no");
            $table->string("serial_no");
            $table->string("part_no");
            $table->string("sku");
            $table->double("available_stock");
            $table->double("purchase_price");
            $table->bigInteger("cat_id")->unsigned();
            $table->foreign("cat_id")->references("id")->on("products_categories")->onDelete("cascade");
            $table->tinyInteger("enable");
            $table->text("image");
            $table->string("currency_unit");
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
        Schema::dropIfExists('products');
    }
}
