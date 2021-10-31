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
            $table->string('product_code')->nullable();
            $table->bigInteger('supplier')->unsigned()->nullable();
            $table->bigInteger("tax")->unsigned()->nullable();
            $table->foreign("tax")->references("id")->on("products_taxes")->onDelete("cascade");
            $table->text("description")->nullable();
            $table->string("model_no")->nullable();
            $table->string("serial_no")->nullable();
            $table->string("part_no")->nullable();
            $table->string("sku")->nullable();
            $table->bigInteger("cat_id")->unsigned()->nullable();
            $table->foreign("cat_id")->references("id")->on("products_categories")->onDelete("cascade");
            $table->tinyInteger("enable")->nullable();
            $table->string('unit')->nullable();
            $table->string('stock_type')->nullable();
            $table->string('barcode')->nullable();
            $table->bigInteger('sub_cat_id')->unsigned()->nullable();
            $table->bigInteger('brand_id')->unsigned()->nullable();
            $table->string("currency_unit")->nullable();
            $table->double('third_party_cost')->nullable();
//            $table->string('unit');
            $table->softDeletes();
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
