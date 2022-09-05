<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePettyCashesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('petty_cashes', function (Blueprint $table) {
            $table->id();
            $table->string('no');
            $table->bigInteger('manager_id')->unsigned();
            $table->bigInteger('tag_finance_id')->unsigned();
            $table->double('amount')->default(0);
            $table->dateTime('date');
            $table->tinyInteger('manager_approve')->default(0);
            $table->tinyInteger('finance_approve')->default(0);
            $table->bigInteger('emp_id')->unsigned();
            $table->text('description')->nullable();
            $table->string('status');
            $table->double('remaining');
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
        Schema::dropIfExists('petty_cashes');
    }
}
