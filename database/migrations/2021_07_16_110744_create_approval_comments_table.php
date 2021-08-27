<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApprovalCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('approval_comments', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('approval_id')->unsigned();
            $table->foreign('approval_id')->references('id')->on('approvalrequests')->onDelete('cascade');
            $table->text('cmt_text');
            $table->bigInteger('emp_id')->unsigned();
            $table->foreign('emp_id')->references('id')->on('employees')->onDelete('cascade');
            $table->text('doc')->nullable();
            $table->index('approval_id');
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
        Schema::dropIfExists('approval_comments');
    }
}
