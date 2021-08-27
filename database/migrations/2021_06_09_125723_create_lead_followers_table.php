<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLeadFollowersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lead_followers', function (Blueprint $table) {
            $table->id();
            $table->bigInteger("follower_id")->unsigned();
            $table->foreign("follower_id")->references("id")->on("employees")->onDelete("cascade");
            $table->bigInteger("lead_id")->unsigned();
            $table->foreign("lead_id")->references("id")->on("lead_models")->onDelete("cascade");
            $table->index('lead_id');
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
        Schema::dropIfExists('lead_followers');
    }
}
