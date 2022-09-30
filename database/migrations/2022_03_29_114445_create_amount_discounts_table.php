<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAmountDiscountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('amount_discounts', function (Blueprint $table) {
            $table->id();
            $table->double('min_amount')->default(0.0);
            $table->double('max_amount')->default(0.0);
            $table->dateTime('start_date')->nullable();
            $table->dateTime('end_date')->nullable();
            $table->tinyInteger('has_date_limit')->default(0);
            $table->integer('rate');
            $table->text('description')->nullable();
            $table->string('sale_type');
            $table->bigInteger('region_id')->unsigned();
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
        Schema::dropIfExists('amount_discounts');
    }
}
