<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDamagedProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('damaged_products', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('variant_id')->unsigned();
            $table->double('qty');
            $table->bigInteger('warehouse_id')->unsigned();
            $table->bigInteger('emp_id')->unsigned();
            $table->bigInteger('branch_id')->nullable();
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
        Schema::dropIfExists('damaged_products');
    }
}
