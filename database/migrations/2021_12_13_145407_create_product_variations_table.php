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
            $table->text('description')->nullable();
            $table->text('serial_no')->nullable();
            $table->double('purchase_price')->default(0.0)->nullable();
            $table->string('product_code')->nullable();
            $table->tinyInteger('enable')->default(0);
            $table->text('image')->nullable();
            $table->text('variant')->nullable();
            $table->tinyInteger('pricing_type')->default(0);
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
