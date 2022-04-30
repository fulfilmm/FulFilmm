<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSaleWaysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sale_ways', function (Blueprint $table) {
            $table->id();
            $table->string('way_id');
            $table->tinyInteger('way_type')->default(0);
            $table->bigInteger('group_id')->unsigned();
            $table->bigInteger('emp_id')->unsigned();
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
        Schema::dropIfExists('sale_ways');
    }
}
