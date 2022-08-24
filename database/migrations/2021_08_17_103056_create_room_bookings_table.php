<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRoomBookingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('room_bookings', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('room_id')->unsigned();
            $table->foreign('room_id')->references('id')->on('rooms')->onDelete('cascade');
            $table->dateTime('start_time')->nullable();
            $table->dateTime('date');
            $table->dateTime('endtime')->nullable();
            $table->bigInteger('created_emp')->unsigned();
            $table->foreign('created_emp')->references('id')->on('employees')->onDelete('cascade');
            $table->text('subject');
            $table->index(['id','room_id']);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('room_bookings');
    }
}
