<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSaleActivitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sale_activities', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->bigInteger('customer_id')->unsigned()->nullable();
            $table->string('activity_type');
            $table->text('description');
            $table->string('type')->nullable();
            $table->dateTime('date');
            $table->bigInteger('report_to')->unsigned();
            $table->bigInteger('emp_id')->unsigned();
            $table->tinyInteger('status')->default(0);
            $table->string('shop')->nullable();
            $table->double('amount')->nullable();
            $table->string('township')->nullable();
            $table->string('address')->nullable();
            $table->text('attachment')->nullable();
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
        Schema::dropIfExists('sale_activities');
    }
}
