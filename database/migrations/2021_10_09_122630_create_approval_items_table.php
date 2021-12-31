<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApprovalItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('approval_items', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('approval_id')->unsigned();
            $table->foreign('approval_id')->references('id')->on('approvalrequests')->onDelete('cascade');
            $table->string('title');
            $table->double('amount');
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
        Schema::dropIfExists('approval_items');
    }
}
