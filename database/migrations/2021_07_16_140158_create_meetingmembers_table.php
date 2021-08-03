<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMeetingmembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('meetingmembers', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('meeting_id')->unsigned();
            $table->bigInteger('member_id')->unsigned();
            $table->tinyInteger('is_accept');
            $table->text('employee_remark')->nullable();
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
        Schema::dropIfExists('meetingmembers');
    }
}
