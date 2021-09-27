<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDealActivitySchedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('deal_activity_schedules', function (Blueprint $table) {
            $table->id();
            $table->bigInteger("deal_id")->unsigned();
            $table->text("description");
            $table->dateTime("to_date");
            $table->dateTime("from_date");
            $table->tinyInteger("work_done");
            $table->index('deal_id');
            $table->text('attach_file')->nullable();
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
        Schema::dropIfExists('deal_activity_schedules');
    }
}
