<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExpenseBudgetItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('expense_budget_items', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('expense_budget_id')->unsigned();
            $table->bigInteger('coa_id')->unsigned();
            $table->bigInteger('total');
            $table->string('cost_center')->nullable();
            $table->double('department')->nullable();
            $table->double('Jan')->default(0);
            $table->double('Feb')->default(0);
            $table->double('Mar')->default(0);
            $table->double('Apr')->default(0);
            $table->double('May')->default(0);
            $table->double('Jun')->default(0);
            $table->double('Jul')->default(0);
            $table->double('Aug')->default(0);
            $table->double('Sep')->default(0);
            $table->double('Oct')->default(0);
            $table->double('Nov')->default(0);
            $table->double('Dec')->default(0);
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
        Schema::dropIfExists('expense_budget_items');
    }
}
