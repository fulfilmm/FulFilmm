<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDealsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('deals', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->double("amount");
            $table->string("unit");
            $table->bigInteger("org_name")->unsigned();
            $table->foreign("org_name")->references("id")->on("companies")->onDelete("cascade");
            $table->bigInteger("contact")->unsigned()->nullable();
            $table->foreign("contact")->references("id")->on("customers")->onDelete("cascade");
            $table->bigInteger("assign_to")->unsigned();
            $table->foreign("assign_to")->references("id")->on("employees")->onDelete("cascade");
            $table->timestamp("close_date");
            $table->string("pipeline");
            $table->string("sale_stage");
            $table->string("lead_source");
            $table->text("next_step")->nullable();
            $table->string("type")->nullable();
            $table->integer("probability");
            $table->double("weighted_revenue")->nullable();
            $table->string("weighed_revenue_unit")->nullable();
            $table->string("lost_reason")->nullable();
            $table->text("description")->nullable();
            $table->bigInteger("created_id")->unsigned();
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
        Schema::dropIfExists('deals');
    }
}
