<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExpenseClaimItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('expense_claim_items', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->double('amount');
            $table->bigInteger('exp_claim_id')->unsigned();
            $table->foreign('exp_claim_id')->references('id')->on('expense_claims')->onDelete('cascade');
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
        Schema::dropIfExists('expense_claim_items');
    }
}
