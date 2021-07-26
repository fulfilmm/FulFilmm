<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTicketFollowersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ticket_followers', function (Blueprint $table) {
            $table->id();
            $table->bigInteger("ticket_id")->unsigned();
            $table->foreign("ticket_id")->references("id")->on("tickets")->onDelete("cascade");
            $table->bigInteger("emp_id")->unsigned();
            $table->foreign("emp_id")->references("id")->on("employees")->onDelete("cascade");
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
        Schema::dropIfExists('ticket_followers');
    }
}
