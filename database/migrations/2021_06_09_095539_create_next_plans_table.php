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
            $table->bigInteger("lead_id")->unsigned();
            $table->foreign("lead_id")->references("id")->on("lead_models")->onDelete("cascade");
            $table->text("description");
            $table->dateTime("to_date");
            $table->dateTime("from_date");
            $table->tinyInteger("work_done");
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
