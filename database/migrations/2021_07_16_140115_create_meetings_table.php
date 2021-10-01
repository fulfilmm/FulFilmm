<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMeetingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('meetings', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('agenda');
            $table->timestamp('date_time');
            $table->string('meeting_type');
            $table->bigInteger('room_no')->unsigned()->nullable();
            $table->foreign('room_no')->references('id')->on('rooms')->onDelete('cascade');
            $table->string('link_id')->nullable();
            $table->string('password')->nullable();
            $table->bigInteger('meeting_creater')->unsigned();
            $table->foreign('meeting_creater')->references('id')->on('employees')->onDelete('cascade');
            $table->index(['id','meeting_creater']);
            $table->text('letter');
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
        Schema::dropIfExists('meetings');
    }
}
