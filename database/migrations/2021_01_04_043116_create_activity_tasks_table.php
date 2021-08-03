<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateActivityTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('activity_tasks', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->foreignId('activity_id');
            $table->unsignedBigInteger('customer_id')->nullable();
            $table->boolean('status')->default(false);
            $table->timestamps();

            $table->foreign('activity_id')
                    ->on('activities')
                    ->references('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('activity_tasks');
    }
}
