<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMinutesAssignsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('minutes_assigns', function (Blueprint $table) {
            $table->id();
            $table->string('assign_type');
            $table->bigInteger('dept_id')->unsigned()->nullable();
            $table->foreign('dept_id')->references('id')->on('departments')->onDelete('cascade');
            $table->bigInteger('emp_id')->unsigned()->nullable();
            $table->foreign('emp_id')->references('id')->on('employees')->onDelete('cascade');
            $table->bigInteger('group_id')->unsigned()->nullable();
            $table->foreign('group_id')->references('id')->on('groups')->onDelete('cascade');
            $table->bigInteger('minutes_id')->unsigned();
            $table->foreign('minutes_id')->references('id')->on('meetingminutes')->onDelete('cascade');
            $table->timestamp('due_date');
            $table->index(['dept_id','emp_id','group_id','minutes_id']);
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
        Schema::dropIfExists('minutes_assigns');
    }
}
