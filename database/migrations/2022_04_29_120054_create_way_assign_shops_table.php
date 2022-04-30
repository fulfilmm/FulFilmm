<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWayAssignShopsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('way_assign_shops', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('way_id')->unsigned();
            $table->bigInteger('shop_id')->unsigned();
            $table->string('reach_location')->nullable();
            $table->tinyInteger('reached')->default(0);
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
        Schema::dropIfExists('way_assign_shops');
    }
}
