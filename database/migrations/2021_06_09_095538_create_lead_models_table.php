<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLeadModelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lead_models', function (Blueprint $table) {
            $table->id();
            $table->string("lead_id");
            $table->string("title");
            $table->bigInteger("created_id")->unsigned();
            $table->bigInteger("customer_id")->unsigned();
            $table->foreign("customer_id")->references("id")->on("customers")->onDelete("cascade");
            $table->string("priority");
            $table->text("description");
            $table->tinyInteger("is_qualified");
            $table->bigInteger("sale_man_id")->unsigned();
            $table->foreign("sale_man_id")->references("id")->on("employees")->onDelete("cascade");
            $table->bigInteger("tags_id")->unsigned();
            $table->foreign("tags_id")->references("id")->on("tags_industries")->onDelete("cascade");
            $table->string("organization_name")->nullable();
            $table->index(['sale_man_id','created_id','is_qualified']);
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
        Schema::dropIfExists('lead_models');
    }
}
