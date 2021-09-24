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
            $table->foreign('meeting_id')->references('id')->on('meetings')->onDelete('cascade');
            $table->bigInteger('member_id')->unsigned()->nullable();
            $table->foreign('member_id')->references('id')->on('employees')->onDelete('cascade');
            $table->bigInteger('external_member_id')->unsigned()->nullable();
            $table->foreign('external_member_id')->references('id')->on('external_meeting_members')->onDelete('cascade');
            $table->tinyInteger('is_accept');
            $table->tinyInteger('is_external')->default(0);
            $table->text('employee_remark')->nullable();
            $table->index(['meeting_id','id']);
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
        Schema::dropIfExists('meetingmembers');
    }
}
