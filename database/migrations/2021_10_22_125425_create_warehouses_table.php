<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWarehousesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('warehouses', function (Blueprint $table) {
            $table->id();
            $table->string('warehouse_id');
            $table->string('name');
            $table->bigInteger('main_warehouse_id')->unsigned()->nullable();
            $table->text('address')->nullable();
            $table->text('description')->nullable();
            $table->tinyInteger('is_virtual')->default(0);//1 is virtual warehouse
            $table->bigInteger('branch_id')->unsigned();
            $table->tinyInteger('mobile_warehouse')->default(0);//1 is mobile warehouse 0 is ground warehouse
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
        Schema::dropIfExists('warehouses');
    }
}
