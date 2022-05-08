<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWayReachShopsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('way_reach_shops', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('assign_id')->unsigned();
            $table->bigInteger('shop_id')->unsigned();
            $table->bigInteger('emp_id')->unsigned()->nullable();
            $table->string('emp_location')->nullable();
            $table->tinyInteger('reach')->default(0);
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
        Schema::dropIfExists('way_reach_shops');
    }
}
