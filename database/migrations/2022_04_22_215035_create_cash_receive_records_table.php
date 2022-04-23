<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCashReceiveRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cash_receive_records', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('emp_id')->unsigned();
            $table->bigInteger('receiver_id')->unsigned();
            $table->bigInteger('sale_manager')->unsigned();
            $table->bigInteger('finance_manager')->unsigned();
            $table->double('amount');
            $table->text('description')->nullable();
            $table->text('attachment')->nullable();
            $table->tinyInteger('receipt')->default(0);
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
        Schema::dropIfExists('cash_receive_records');
    }
}
