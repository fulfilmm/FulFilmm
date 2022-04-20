<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSaleReturnsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sale_returns', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('invoice_id')->unsigned();
            $table->bigInteger('customer_id')->unsigned();
            $table->bigInteger('branch_id')->unsigned();
            $table->bigInteger('sale_man_id')->unsigned();
            $table->string('category')->nullable();
            $table->double('amount')->default(0);
            $table->text('attach')->nullable();
            $table->text('reason')->nullable();
            $table->bigInteger('cashier_id')->unsigned();
            $table->bigInteger('account_id')->unsigned();
            $table->tinyInteger('approve')->default(0);
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
        Schema::dropIfExists('sale_returns');
    }
}
