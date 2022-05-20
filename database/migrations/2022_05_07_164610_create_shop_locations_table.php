<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShopLocationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shop_locations', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->bigInteger('emp_id')->unsigned();
            $table->string('location');
            $table->bigInteger('customer_id')->nullable();
            $table->text('picture')->nullable();
            $table->string('contact');
            $table->string('phone');
            $table->text('description')->nullable();
            $table->bigInteger('branch_id')->unsigned();
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
        Schema::dropIfExists('shop_locations');
    }
}
