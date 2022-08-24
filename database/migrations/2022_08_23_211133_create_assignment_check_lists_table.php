<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssignmentCheckListsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assignment_check_lists', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('assignment_id')->unsigned();
            $table->bigInteger('emp_id')->unsigned();
            $table->tinyInteger('remark')->default(0);
            $table->text('description');
            $table->tinyInteger('done')->default(0);
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
        Schema::dropIfExists('assignment_check_lists');
    }
}
