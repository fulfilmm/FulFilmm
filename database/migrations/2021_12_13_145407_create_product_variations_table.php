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
            $table->text('description')->nullable();
            $table->double('price')->default(0.0)->nullable();
            $table->double('purchase_price')->default(0.0)->nullable();
            $table->string('product_code')->nullable();
            $table->string('barcode')->nullable();
            $table->double('discount_rate')->nullable();
            $table->dateTime('exp_date')->nullable();
            $table->text('image')->nullable();
            $table->string('size')->nullable();
            $table->string('color')->nullable();
            $table->string('other')->nullable();
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
