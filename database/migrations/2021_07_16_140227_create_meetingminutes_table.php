<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMeetingminutesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('meetingminutes', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('meeting_id')->unsigned();
            $table->foreign('meeting_id')->references('id')->on('meetings')->onDelete('cascade');
            $table->string('minutes_no');
            $table->text('minutes_text');
            $table->text('attach_file')->nullable();
            $table->boolean('is_assign')->default(false);
            $table->tinyInteger('is_complete');
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
        Schema::dropIfExists('meetingminutes');
    }
}
