<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAlertDateTimeIntoNextPlan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('next_plans', function (Blueprint $table) {
            $table->dateTime('alert_date')->default(\Carbon\Carbon::now());
            $table->string('repeat')->default(0);
            $table->string('repeat_type')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('next_plans', function (Blueprint $table) {
            $table->drop('alert_date');
            $table->drop('repeat');
            $table->drop('repeat_type');
        });
    }
}
