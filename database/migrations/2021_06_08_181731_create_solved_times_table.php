<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSolvedTimesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('solved_times', function (Blueprint $table) {
            $table->id();
            $table->bigInteger("agent_id")->unsigned();
            $table->foreign("agent_id")->references("id")->on("employees")->onDelete('cascade');
            $table->bigInteger("priority")->unsigned();
            $table->foreign("priority")->references("id")->on("priorities")->onDelete('cascade');
            $table->bigInteger("ticket_id")->unsigned();
            $table->foreign("ticket_id")->references("id")->on("tickets")->onDelete('cascade');
            $table->timestamp("startedTime");
            $table->timestamp("endTime")->nullable();
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
        Schema::dropIfExists('solved_times');
    }
}
