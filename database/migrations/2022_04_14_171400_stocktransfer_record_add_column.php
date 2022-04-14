<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class StocktransferRecordAddColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('stock_transfer_records', function (Blueprint $table) {
            $table->double('validate_qty')->default(0);
            $table->tinyInteger('validated')->default(0);

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('stock_transfer_records', function (Blueprint $table) {
            $table->drop('validate_qty');
            $table->drop('validated');
        });
    }
}
