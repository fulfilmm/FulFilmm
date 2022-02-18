<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRFQItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('r_f_q_items', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('rfq_id')->unsigned()->nullable();
            $table->bigInteger('product_id')->unsigned();
            $table->text('description')->nullable();
            $table->double('qty');
            $table->string('unit')->nullable();
            $table->double('price')->nullable();
            $table->string('creation_id');
            $table->double('total')->default(0);
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
        Schema::dropIfExists('r_f_q_items');
    }
}
