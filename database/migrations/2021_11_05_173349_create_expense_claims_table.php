<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExpenseClaimsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('expense_claims', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->bigInteger('emp_id')->unsigned();
            $table->bigInteger('approver_id')->unsigned();
            $table->string('status');//for reject,pending,approve
            $table->text('tag_emp')->nullable();
            $table->text('description')->nullable();
            $table->dateTime('date');
            $table->double('total');
            $table->bigInteger('financial_approver')->unsigned();
            $table->text('attach')->nullable();
            $table->tinyInteger('is_claim')->default(0);//for is cash claim or un claim
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
        Schema::dropIfExists('expense_claims');
    }
}
