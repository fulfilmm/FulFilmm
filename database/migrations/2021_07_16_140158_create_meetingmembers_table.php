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
            $table->bigInteger('member_id')->unsigned()->nullable();
            $table->bigInteger('exeternal_member_id')->unsigned()->nullable();
            $table->tinyInteger('is_accept');
            $table->tinyInteger('is_external')->default(0);
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
