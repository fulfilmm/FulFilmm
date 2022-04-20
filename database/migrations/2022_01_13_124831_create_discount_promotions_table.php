<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDiscountPromotionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('discount_promotions', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('variant_id')->unsigned();
            $table->integer('rate')->default(0);
            $table->dateTime('start_date')->nullable();
            $table->dateTime('end_date')->nullable();
            $table->text('description')->nullable();
            $table->bigInteger('branch_id')->unsigned();
            $table->string('sale_type');
            $table->string('type');
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
        Schema::dropIfExists('discount_promotions');
    }
}
