<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApprovalrequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('approvalrequests', function (Blueprint $table) {
            $table->id();
            $table->string('approval_id');
            $table->string('title');
            $table->dateTime('target_date');
            $table->string('state')->nullable();
            $table->text('content');
            $table->text('doc_file')->nullable();
            $table->bigInteger('approved_id')->unsigned();
            $table->foreign('approved_id')->references('id')->on('employees')->onDelete('cascade');
            $table->bigInteger('secondary_approved')->unsigned()->nullable();
            $table->foreign('secondary_approved')->references('id')->on('employees')->onDelete('cascade');
            $table->bigInteger('emp_id')->unsigned();
            $table->foreign('emp_id')->references('id')->on('employees')->onDelete('cascade');
            $table->index(['id','approved_id','secondary_approved']);
            $table->dateTime('from_date')->nullable();
            $table->string('type');
            $table->dateTime('to_date')->nullable();
            $table->double('amount')->nullable();
            $table->text('location')->nullable();
            $table->bigInteger('contact_id')->unsigned()->nullable();
            $table->text('trip_members')->nullable();
            $table->string('quantity')->nullable();
            $table->tinyInteger('approver_noti')->default(0);
            $table->tinyInteger('requester_noti')->default(1);
            $table->softDeletes();
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
        Schema::dropIfExists('approvalrequests');
    }
}
