<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssginmentCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assginment_comments', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('assignment_id')->unsigned();
            $table->bigInteger('emp_id')->unsigned();
            $table->text('comment');
            $table->text('attach')->nullable();
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
        Schema::dropIfExists('assginment_comments');
    }
}
