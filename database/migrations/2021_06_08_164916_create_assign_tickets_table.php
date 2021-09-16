<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssignTicketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assign_tickets', function (Blueprint $table) {
            $table->id();
            $table->bigInteger("agent_id")->unsigned()->nullable();
            $table->bigInteger("ticket_id")->unsigned();
            $table->bigInteger('dept_id')->unsigned()->nullable();
            $table->string("type_of_assign");
            $table->bigInteger('group_id')->unsigned()->nullable();
            $table->index(['agent_id','ticket_id','dept_id','group_id']);
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
        Schema::dropIfExists('assign_tickets');
    }
}
