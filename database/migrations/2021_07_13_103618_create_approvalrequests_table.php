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
            $table->bigInteger('secondary_approved')->unsigned()->nullable();
            $table->bigInteger('emp_id')->unsigned();
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
