<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCcOfApprovalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cc_of_approvals', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('approval_id')->unsigned();
            $table->foreign('approval_id')->references('id')->on('approvalrequests')->onDelete('cascade');
            $table->bigInteger('emp_id')->unsigned();
            $table->foreign('emp_id')->references('id')->on('employees')->onDelete('cascade');
            $table->index(['approval_id','emp_id']);
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
        Schema::dropIfExists('cc_of_approvals');
    }
}
