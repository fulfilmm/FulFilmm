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
            $table->string("name")->nullable();
            $table->string('deal_id');
            $table->double("amount");
            $table->string("unit");
            $table->bigInteger("org_name")->unsigned()->nullable();
            $table->foreign("org_name")->references("id")->on("companies")->onDelete("cascade");
            $table->bigInteger("contact")->unsigned()->nullable();
            $table->foreign("contact")->references("id")->on("customers")->onDelete("cascade");
            $table->bigInteger("assign_to")->unsigned()->nullable();
            $table->foreign("assign_to")->references("id")->on("employees")->onDelete("cascade");
            $table->timestamp("close_date")->nullable();
            $table->string("pipeline")->nullable();
            $table->string("sale_stage");
            $table->string("lead_source")->nullable();
            $table->string('lead_title');
            $table->text("next_step")->nullable();
            $table->string("type")->nullable();
            $table->integer("probability")->nullable();
            $table->string("lost_reason")->nullable();
            $table->text("description")->nullable();
            $table->bigInteger("created_id")->unsigned();
            $table->foreign('created_id')->references('id')->on('employees')->onDelete('cascade');
            $table->index(['created_id','assign_to','contact','org_name','id']);
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
        Schema::dropIfExists('deals');
    }
}
