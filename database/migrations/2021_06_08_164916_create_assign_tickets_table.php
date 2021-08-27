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
            $table->foreign("agent_id")->references('id')->on('employees')->onDelete('cascade');;
            $table->bigInteger("ticket_id")->unsigned();
            $table->foreign("ticket_id")->references('id')->on('tickets')->onDelete('cascade');;
            $table->bigInteger('dept_id')->unsigned()->nullable();
            $table->foreign("dept_id")->references("id")->on("departments")->onDelete('cascade');
            $table->string("type_of_assign");
            $table->bigInteger('group_id')->unsigned()->nullable();
            $table->foreign('group_id')->references('id')->on('groups')->onDelete('cascade');
            $table->index(['agent_id','ticket_id','dept_id','group_id']);
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
        Schema::dropIfExists('assign_tickets');
    }
}
