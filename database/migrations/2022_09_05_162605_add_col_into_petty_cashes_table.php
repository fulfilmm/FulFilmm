<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColIntoPettyCashesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('petty_cashes', function (Blueprint $table) {
            $table->string('priority')->default('High');
            $table->dateTime('target_date')->default(\Carbon\Carbon::today());
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('petty_cashes', function (Blueprint $table) {
            //
        });
    }
}
