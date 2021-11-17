<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNextPlansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('next_plans', function (Blueprint $table) {
            $table->id();
            $table->bigInteger("contact_id")->unsigned();
            $table->text("description");
            $table->string('type');
            $table->dateTime("date_time");
            $table->tinyInteger("work_done");
            $table->index('contact_id');
            $table->text('attach_file')->nullable();
            $table->bigInteger('emp_id')->unsigned();
            $table->softDeletes();
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
        Schema::dropIfExists('next_plans');
    }
}
