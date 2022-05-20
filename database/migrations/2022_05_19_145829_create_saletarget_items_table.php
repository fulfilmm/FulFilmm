<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSaletargetItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('saletarget_items', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('sale_target_id')->unsigned();
            $table->bigInteger('item_id')->unsigned();
            $table->double('target_qty')->default(0);
            $table->double('sold_qty')->default(0);
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
        Schema::dropIfExists('saletarget_items');
    }
}
