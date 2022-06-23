<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewColumnIntoShop extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('shop_locations', function (Blueprint $table) {
            $table->bigInteger('region_id')->unsigned();
            $table->bigInteger('zone_id')->unsigned();
            $table->string('township')->nullable();
            $table->string('address')->nullable();
            $table->string('shop_type')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('shop_locations', function (Blueprint $table) {
            $table->drop('region_id');
            $table->drop('zone_id');
            $table->drop('township');
            $table->drop('address');
        });
    }
}
