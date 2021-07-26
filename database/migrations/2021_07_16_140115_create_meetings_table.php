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
            $table->string('address')->nullable();
            $table->string('room_no')->nullable();
            $table->string('link_id')->nullable();
            $table->string('password')->nullable();
            $table->text('guest_member')->nullable();
            $table->bigInteger('meeting_creater')->unsigned();
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
