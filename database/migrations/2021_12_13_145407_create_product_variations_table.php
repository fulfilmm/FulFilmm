<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductVariationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_variations', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('product_id')->unsigned()->nullable();
            $table->string('product_name');
            $table->double('purchase_price')->default(0.0)->nullable();
            $table->string('item_code')->nullable();
            $table->tinyInteger('enable')->default(0);
            $table->text('image')->nullable();
            $table->text('variant')->nullable();
            $table->double('additional_price')->default(0);
            $table->tinyInteger('pricing_type')->default(0);//1 is multi 0 is single
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
        Schema::dropIfExists('product_variations');
    }
}
