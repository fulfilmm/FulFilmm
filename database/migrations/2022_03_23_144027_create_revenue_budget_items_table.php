<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRevenueBudgetItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('revenue_budget_items', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('revenue_budget_id')->unsigned();
            $table->bigInteger('coa_id')->unsigned();
            $table->bigInteger('total');
            $table->string('cost_center')->nullable();
            $table->string('department')->nullable();
            $table->double('jan')->default(0);
            $table->double('feb')->default(0);
            $table->double('mar')->default(0);
            $table->double('apr')->default(0);
            $table->double('may')->default(0);
            $table->double('jun')->default(0);
            $table->double('jul')->default(0);
            $table->double('aug')->default(0);
            $table->double('sep')->default(0);
            $table->double('oct')->default(0);
            $table->double('nov')->default(0);
            $table->double('dec')->default(0);
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
        Schema::dropIfExists('revenue_budget_items');
    }
}
