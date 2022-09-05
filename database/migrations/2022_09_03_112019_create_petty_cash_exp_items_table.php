<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePettyCashExpItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('petty_cash_exp_items', function (Blueprint $table) {
            $table->id();
            $table->dateTime('date');
            $table->string('purpose')->nullable();
            $table->double('amount')->default(0.0);
            $table->bigInteger('petty_cash_id')->unsigned();
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
        Schema::dropIfExists('petty_cash_exp_items');
    }
}
