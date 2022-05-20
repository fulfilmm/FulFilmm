<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesWayAssignsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales_way_assigns', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('way_id')->unsigned();
            $table->bigInteger('group_id')->unsigned()->nullable();
            $table->bigInteger('emp_id')->unsigned()->nullable();
            $table->tinyInteger('type');//1 is group 0 is employee assign
            $table->tinyInteger('assigned_emp')->unsigned();
            $table->dateTime('start_date')->nullable();
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
        Schema::dropIfExists('sales_way_assigns');
    }
}
